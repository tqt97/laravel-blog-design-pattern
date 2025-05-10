<?php

namespace App\Services\Admin;

use App\Helpers\ImageHelper;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class CategoryService
{
    public function __construct(
        protected ImageService $imageService
    ) {}

    /**
     * Retrieve a paginated list of categories with optional filters.
     *
     * @param  array  $filters  Optional filters for querying categories.
     * @return LengthAwarePaginator A paginator instance containing the categories.
     */
    public function getList(array $filters = []): LengthAwarePaginator
    {
        return Category::query()->select('id', 'name', 'slug', 'parent_id', 'order', 'is_active', 'created_at', 'updated_at')
            ->with([
                'image:id,imageable_id,imageable_type,path,url,disk',
                'parent:id,name',
            ])
            ->filter($filters)
            ->paginate(10)
            ->withQueryString();
    }

    /**
     * Create a new category.
     *
     * @param  StoreCategoryRequest  $request  The input data for creating a new category.
     * @return bool True if the category is created successfully, false otherwise.
     */
    // public function create(StoreCategoryRequest $request): bool
    // {
    //     try {
    //         DB::beginTransaction();
    //         $category = Category::query()->create($request->only('name', 'slug', 'parent_id', 'order', 'is_active'));

    //         // Handle upload image
    //         if ($request->hasFile('image')) {
    //             // $this->attachImage($category, $request->file('image'));
    //             $this->imageService->attach($category, $request->file('image'), 'categories');
    //         }
    //         DB::commit();

    //         return true;
    //     } catch (Throwable $e) {
    //         DB::rollBack();
    //         Log::error('Create Category Failed: ' . $e->getMessage());

    //         return false;
    //     }
    // }
    public function create(StoreCategoryRequest $request): ?Category
    {
        return DB::transaction(function () use ($request) {
            $category = Category::query()->create($request->only('name', 'slug', 'parent_id', 'order', 'is_active'));

            if ($request->hasFile('image')) {
                $this->imageService->attach($category, $request->file('image'), 'categories');
            }

            return $category;
        });
    }

    /**
     * Update an existing category.
     *
     * @param  UpdateCategoryRequest  $request  The input data for updating an existing category.
     * @param  Category  $category  The category to be updated.
     * @return bool True if the category is updated successfully, false otherwise.
     */
    // public function update(UpdateCategoryRequest $request, Category $category): bool
    // {
    //     try {
    //         DB::beginTransaction();
    //         $category->update($request->only('name', 'slug', 'parent_id', 'order', 'is_active'));
    //         $oldPath = $category->image?->path;

    //         // Handle upload image
    //         if ($request->hasFile('image')) {
    //             // $this->attachImage($category, $request->file('image'));
    //             $this->imageService->attach($category, $request->file('image'), 'categories');
    //         }
    //         DB::commit();

    //         if ($request->hasFile('image') && $oldPath) {
    //             ImageHelper::delete($oldPath);
    //             // TODO: if delete old image failed -> trigger event job to clear
    //         }
    //         DB::afterCommit(function () use ($category) {
    //             $category->refresh();
    //         });
    //         return true;
    //     } catch (Throwable $e) {
    //         DB::rollBack();
    //         Log::error('Update Category Failed: ' . $e->getMessage());

    //         return false;
    //     }
    // }

    public function update(UpdateCategoryRequest $request, Category $category): Category
    {
        $oldPath = $category->image?->path;

        return DB::transaction(function () use ($category, $request, $oldPath) {
            $category->update($request->only('name', 'slug', 'parent_id', 'order', 'is_active'));

            if ($request->hasFile('image')) {
                $this->imageService->attach($category, $request->file('image'), 'categories');

                if ($oldPath) {
                    DB::afterCommit(fn () => ImageHelper::delete($oldPath));
                }
            }

            return $category;
        });
    }

    /**
     * Delete the specified category.
     *
     * @param  Category  $category  The category to be deleted.
     * @return bool True if the category is deleted successfully, false otherwise.
     */
    public function delete(Category $category): bool
    {
        // TODO: if category has child -> trigger event job to clear
        // TODO if category has posts -> trigger event job to clear
        return $this->deleteWithChildren($category);
    }

    public function deleteMultiple(Request $request): bool
    {
        $ids = explode(',', $request->input('ids'));

        return $this->deleteMultipleWithChildren($ids);
    }

    // public function deleteWithChildren(Category $category): bool
    // {
    //     try {
    //         DB::beginTransaction();

    //         // 1. Lấy toàn bộ danh mục con đệ quy
    //         $descendants = $this->getAllDescendantCategories($category);

    //         // 2. Gom toàn bộ category cần xóa (cha + các con)
    //         $allCategories = $descendants->push($category);

    //         // 3. Gom toàn bộ ảnh liên quan
    //         $images = Image::query()
    //             ->whereIn('imageable_id', $allCategories->pluck('id'))
    //             ->where('imageable_type', Category::class)
    //             ->get();

    //         // 4. Xoá ảnh trong DB
    //         Image::query()
    //             ->whereIn('imageable_id', $allCategories->pluck('id'))
    //             ->where('imageable_type', Category::class)
    //             ->delete();

    //         // 5. Xoá tất cả danh mục trong DB
    //         Category::query()->whereIn('id', $allCategories->pluck('id'))->delete();

    //         DB::commit();

    //         // 6. Sau khi commit mới xoá file vật lý
    //         $images->each(fn($image): bool => ImageHelper::delete($image->path));

    //         return true;
    //     } catch (Throwable $e) {
    //         DB::rollBack();
    //         Log::error('Delete Category with children failed: ' . $e->getMessage());

    //         return false;
    //     }
    // }
    public function deleteWithChildren(Category $category): void
    {
        $images = DB::transaction(function () use ($category) {
            // 1. Lấy toàn bộ danh mục con đệ quy
            $descendants = $this->getAllDescendantCategories($category);

            // 2. Gom toàn bộ category cần xóa (cha + các con)
            $allCategories = $descendants->push($category);

            // 3. Gom toàn bộ ảnh liên quan
            $images = Image::query()
                ->whereIn('imageable_id', $allCategories->pluck('id'))
                ->where('imageable_type', Category::class)
                ->get();

            // 4. Xoá ảnh trong DB
            Image::query()
                ->whereIn('imageable_id', $allCategories->pluck('id'))
                ->where('imageable_type', Category::class)
                ->delete();

            // 5. Xoá tất cả danh mục trong DB
            Category::query()->whereIn('id', $allCategories->pluck('id'))->delete();

            // Trả danh sách ảnh để xử lý sau commit
            return $images;
        });

        // 6. Sau khi commit, xoá file vật lý
        DB::afterCommit(fn () => $images->each(fn ($image) => ImageHelper::delete($image->path)));
    }

    // public function deleteWithChildren(Category $category): void
    // {
    //     $images = DB::transaction(function () use ($category) {
    //         $descendants = $this->categoryRepo->getAllDescendantCategories($category);
    //         $allCategories = $descendants->push($category);

    //         $images = $this->categoryRepo->getImagesByCategoryIds($allCategories->pluck('id'));

    //         $this->categoryRepo->deleteByIds($allCategories->pluck('id'));

    //         $this->imageService->deleteMultiple($images);

    //         return $images;
    //     });

    //     DB::afterCommit(fn() => $images->each(fn($img) => ImageHelper::delete($img->path)));
    // }

    public function deleteMultipleWithChildren(array $ids): bool
    {
        if ($ids === []) {
            return false;
        }

        try {
            DB::beginTransaction();

            // $categories = Category::query()->whereIn('id', $ids)->get();

            // Dùng Collection để gom ID không trùng
            $allCategories = collect();

            // foreach ($categories as $category) {
            //     $descendants = $this->getAllDescendantCategories($category);
            //     // $allCategories = $allCategories->merge($descendants)->push($category);
            //     $allCategories->push($category);
            //     $allCategories = $allCategories->merge($descendants);

            // }
            Category::query()
                ->whereIn('id', $ids)
                ->with('children')
                ->get()
                ->each(function (Category $category) use (&$allCategories): void {
                    $allCategories->push($category);
                    $allCategories = $allCategories->merge($this->getAllDescendantCategories($category));
                });

            $allCategoryIds = $allCategories->pluck('id')->unique();

            $images = Image::query()
                ->whereIn('imageable_id', $allCategoryIds)
                ->where('imageable_type', Category::class)
                ->get();

            Image::query()
                ->whereIn('imageable_id', $allCategoryIds)
                ->where('imageable_type', Category::class)
                ->delete();

            Category::query()->whereIn('id', $allCategoryIds)->delete();

            DB::commit();

            $images->each(fn ($image): bool => ImageHelper::delete($image->path));

            return true;
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Bulk Delete Categories with children failed: '.$e->getMessage());

            return false;
        }
    }

    /**
     * Get all descendant category IDs of the given category (recursive DFS).
     */
    public function getAllDescendantCategories(Category $category): Collection
    {
        $descendants = collect();

        $category->loadMissing('children');

        foreach ($category->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($this->getAllDescendantCategories($child));
        }

        return $descendants;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\Admin\CategoryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $service) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // $ids = [1, 2, 3, 45, 87, 9, 24, 32, 27];
        // $categories = Category::query()->whereIn('id', $ids)->get();

        // Dùng Collection để gom ID không trùng
        // $allCategories = collect();

        // foreach ($categories as $category) {
        //     $descendants = $this->getAllDescendantCategories($category);
        //     // $allCategories = $allCategories->merge($descendants)->push($category);
        //     $allCategories->push($category);
        //     $allCategories = $allCategories->merge($descendants);

        // }
        // Category::query()
        //     ->whereIn('id', $ids)
        //     ->with('children')
        //     ->get()
        //     ->each(function (Category $category) use (&$allCategories): void {
        //         $allCategories->push($category);
        //         $allCategories = $allCategories->merge($this->getAllDescendantCategories($category));
        //     });

        // return view('admin.categories.test', ['allCategories' => $allCategories]);

        $categories = $this->service->getList($request->only(['search', 'sort_by', 'sort_dir']));

        return view('admin.categories.index', ['categories' => $categories]);
    }

    public function getAllDescendantCategories(Category $category)
    {
        $descendants = collect();

        $category->loadMissing('children');

        foreach ($category->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($this->getAllDescendantCategories($child));
        }

        return $descendants;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::query()->select('id', 'name')->get();

        return view('admin.categories.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(StoreCategoryRequest $request): RedirectResponse
    // {
    //     if ($this->service->create($request)) {
    //         return to_route('admin.categories.index')->withSuccess(__('category.messages.create_success'));
    //     }

    //     return back()->with('error', __('category.messages.error_create'));
    // }
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        try {
            $this->service->create($request);

            return to_route('admin.categories.index')
                ->withSuccess(__('category.messages.create_success'));
        } catch (\Throwable $e) {
            Log::error('Create Category Failed: '.$e->getMessage());

            return back()
                ->withInput()
                ->with('error', __('category.messages.error_create'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): View
    {
        return view('admin.categories.show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        $categories = Category::query()->select('id', 'name', 'parent_id')->get();

        return view('admin.categories.edit', ['category' => $category, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateCategoryRequest $request, Category $category)
    // {
    //     if ($this->service->update($request, $category)) {
    //         return to_route('admin.categories.index')->withSuccess(__('category.messages.update_success'));
    //     }

    //     return back()->with('error', __('category.messages.error_update'));
    // }
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        try {
            $this->service->update($request, $category);

            return to_route('admin.categories.index')
                ->withSuccess(__('category.messages.update_success'));
        } catch (\Throwable $e) {
            Log::error('Update Category Failed: '.$e->getMessage());

            return back()
                ->withInput()
                ->with('error', __('category.messages.error_update'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Category $category)
    // {
    //     if ($this->service->delete($category)) {
    //         return to_route('admin.categories.index')->withSuccess(__('category.messages.delete_success'));
    //     }

    //     return back()->with('error', __('category.messages.error_delete'));
    // }
    public function destroy(Category $category): RedirectResponse
    {
        try {
            $this->service->delete($category);

            return to_route('admin.categories.index')
                ->withSuccess(__('category.messages.delete_success'));
        } catch (\Throwable $e) {
            Log::error('Delete Category Failed: '.$e->getMessage());

            return back()->with('error', __('category.messages.error_delete'));
        }
    }

    public function destroyMultiple(Request $request)
    {
        if ($this->service->deleteMultiple($request)) {
            return to_route('admin.categories.index')->withSuccess(__('category.messages.delete_success'));
        }

        return back()->with('error', __('category.messages.error_delete'));
    }
}

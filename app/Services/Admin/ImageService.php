<?php

namespace App\Services\Admin;

use App\Helpers\ImageHelper;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ImageService
{
    /**
     * Attach or update an image to a model.
     */
    public function attach(Model $model, UploadedFile $file, ?string $collection = null): Image
    {
        try {
            $path = ImageHelper::store($file, $collection ?? 'default', 'public');

            return $model->image()->updateOrCreate([
                'imageable_type' => get_class($model),
                'imageable_id' => $model->id,
            ], [
                'path' => $path,
                'url' => Storage::disk('public')->url($path),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'alt_text' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'is_default' => true,
                'collection' => $collection ?? 'default',
            ]);
        } catch (Throwable $e) {
            Log::error("Attach image failed: {$e->getMessage()}");
            throw $e; // bubble lên để DB transaction xử lý
        }
    }

    /**
     * Delete the image record and physical file.
     */
    public function delete(Image $image): bool
    {
        try {
            $image->delete();
            ImageHelper::delete($image->path);

            return true;
        } catch (Throwable $e) {
            Log::error("Delete image failed: {$e->getMessage()}");

            return false;
        }
    }

    /**
     * Delete image of a specific model (morphOne).
     */
    public function deleteByModel(Model $model): bool
    {
        if (! $model->relationLoaded('image')) {
            $model->load('image');
        }

        if ($model->image) {
            return $this->delete($model->image);
        }

        return true;
    }

    /**
     * Delete images of multiple models (morphOne).
     */
    public function deleteByModels(Collection $models): bool
    {
        $modelIds = $models->pluck('id');
        $modelClass = get_class($models->first());

        $images = Image::query()
            ->whereIn('imageable_id', $modelIds)
            ->where('imageable_type', $modelClass)
            ->get();

        return $this->deleteMultiple($images);
    }

    /**
     * Delete multiple images and their files.
     */
    public function deleteMultiple(Collection $images): bool
    {
        try {
            $paths = $images->pluck('path')->all();
            Image::whereIn('id', $images->pluck('id'))->delete();

            foreach ($paths as $path) {
                ImageHelper::delete($path);
            }

            return true;
        } catch (Throwable $e) {
            Log::error("Bulk delete images failed: {$e->getMessage()}");

            return false;
        }
    }

    /**
     * Only delete image records in DB (without physical files).
     */
    public function deleteInDatabase(Collection $images): bool
    {
        try {
            Image::whereIn('id', $images->pluck('id'))->delete();

            return true;
        } catch (Throwable $e) {
            Log::error("Delete images in DB failed: {$e->getMessage()}");

            return false;
        }
    }

    /**
     * Only delete physical files by paths.
     */
    public function deleteFilesByPaths(array $paths): void
    {
        foreach ($paths as $path) {
            ImageHelper::delete($path);
        }
    }
}

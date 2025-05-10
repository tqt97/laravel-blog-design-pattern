<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasManyImages
{
    /**
     * Define morphMany relationship to images.
     *
     * @return MorphMany<Image, $this>
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Get the default image (if any).
     *
     * @return MorphMany<Image, $this>
     */
    public function defaultImage(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable')->where('is_default', true);
    }

    /**
     * Get image URL from default image (if any).
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->images()->where('is_default', true)->first()?->url
            ?? $this->images()->first()?->url;
    }

    /**
     * Attach a new image to the model.
     */
    public function attachImage(array $data): void
    {
        $this->images()->create($data);
    }

    /**
     * Detach a specific image by ID.
     */
    public function detachImage(int $imageId): void
    {
        $this->images()->where('id', $imageId)->delete();
    }

    /**
     * Clear all images.
     */
    public function clearImages(): void
    {
        $this->images()->delete();
    }

    /**
     * Replace current default image with a new one.
     */
    public function replaceDefaultImage(array $data): void
    {
        $this->images()->where('is_default', true)->update(['is_default' => false]);
        $this->images()->create($data + ['is_default' => true]);
    }

    /**
     * Get all image paths (useful for file deletion).
     */
    public function getImagePaths(): array
    {
        return $this->images->pluck('path')->toArray();
    }
}

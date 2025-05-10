<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasOneImage
{
    /**
     * @return MorphOne<Image, $this>
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * Get the URL of the image from storage, if one is attached.
     *
     * If no image is attached, this method will return image default.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image?->url ?? asset('assets/images/image-default.jpg');
    }

    /**
     * @return MorphOne<Image, $this>
     */
    public function defaultImage(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')->where('is_default', true);
    }

    /**
     * Attach a new image to the model.
     */
    public function attachImage(array $data): void
    {
        $this->image()->create($data);
    }

    /**
     * Detach the image from the model.
     *
     * If no image is attached, this method does nothing.
     */
    public function detachImage(): void
    {
        $this->image?->delete();
    }

    /**
     * Get the path of the image.
     *
     * @return string|null The image path or null if no image is attached.
     */
    public function getImagePath(): ?string
    {
        return $this->image?->path;
    }
}

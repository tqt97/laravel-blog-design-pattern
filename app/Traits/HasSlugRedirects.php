<?php

namespace App\Traits;

use App\Models\SlugRedirect;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasSlugRedirects
{
    /**
     * When the slug of a model is changed, create a new SlugRedirect entry.
     *
     * This method listens for the "updating" event on the model, which is
     * triggered whenever the model is about to be saved. If the slug of the
     * model has changed, a new SlugRedirect entry is created with the old
     * slug and the new slug.
     *
     * This allows us to redirect from the old slug to the new slug when the
     * old slug is requested, so that users can still access the model even
     * if the slug has changed.
     */
    public static function bootHasSlugRedirects(): void
    {
        static::updating(function ($model): void {
            // If the slug has changed, create a SlugRedirect entry to redirect
            // from the old slug to the new slug.
            if ($model->isDirty('slug')) {
                SlugRedirect::query()->create([
                    'old_slug' => $model->getOriginal('slug'),
                    'new_slug' => $model->slug,
                    'model_type' => get_class($model),
                    'model_id' => $model->getKey(),
                ]);
            }
        });
    }

    /**
     * Get the redirects for this model.
     *
     * Returns a relationship for the SlugRedirect entries that are related to
     * this model. This is useful for listing all the redirects for a given
     * model.
     *
     * @return HasMany
     */
    public function redirects()
    {
        return $this->hasMany(SlugRedirect::class, 'model_id')
            ->where('model_type', $this->getMorphClass());
    }
}

<?php

namespace App\Traits;

use App\Supports\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    /**
     * Boot the trait.
     *
     * This method will be called when the model is booting, and is used to
     * register any event listeners. In this case, it will register a listener
     * for the creating and updating events.
     */
    public static function bootHasSlug(): void
    {
        static::creating(function (Model $model): void {
            // Before creating the model, generate the slug.
            $model->generateSlug();
        });

        static::updating(function (Model $model): void {
            // Get the options for generating the slug
            $options = $model->getSlugOptions();

            // If the slug should not be overwritten on update, skip.
            // This is useful for cases where the slug is changed by the user.
            if (! $options->allowOverwriteOnUpdate() && $model->getOriginal($options->to()) !== $model->{$options->to()}) {
                return; // Nếu không cho phép ghi đè, không cập nhật slug
            }

            // If the slug has not changed during the update, skip.
            // This is useful for cases where the slug is not changed by the user.
            if (! $model->isDirty($options->to())) {
                return;
            }

            // If the user has changed the slug, update it.
            // This is useful for cases where the slug is changed by the user.
            $model->generateSlug();
        });
    }

    /**
     * Generates a slug based on the given field or the model's own slug,
     * ensuring uniqueness if the option is set.
     */
    public function generateSlug(): void
    {
        // Retrieve the options for generating the slug
        $options = $this->getSlugOptions();

        // Get the source value to generate the slug from
        // If the source field is empty, use the model's own slug
        $source = $this->{$options->to()} ?? $this->{$options->from()};

        // If there's no value to generate the slug from, skip
        if (empty($source)) {
            return;
        }

        // Generate the slug from the source value
        // Use the separator specified in the options
        $slug = Str::slug($source, $options->separator());

        // If the slug should be unique, check if it already exists
        if ($options->shouldBeUnique()) {
            // Make the slug unique by appending a suffix if necessary
            $slug = $this->makeSlugUnique($slug, $options);
        }

        // Set the slug on the model
        $this->{$options->to()} = $slug;
    }

    /**
     * Ensure the provided slug is unique by appending a suffix if necessary.
     *
     * This function checks if the given base slug already exists in the database.
     * If it does, it appends an incrementing suffix until a unique slug is found.
     *
     * @param  string  $baseSlug  The initial slug to ensure uniqueness for.
     * @param  SlugOptions  $options  Options for generating the slug, including the target field and separator.
     * @return string A unique slug based on the provided baseSlug.
     */
    protected function makeSlugUnique(string $baseSlug, SlugOptions $options): string
    {
        $slug = $baseSlug;
        $i = 1;

        // Create a query to check if the slug already exists in the database
        $query = static::query()->where($options->to(), $slug);

        // If this object already exists in the database, ensure we do not compare with itself
        if ($this->exists) {
            $query->whereKeyNot($this->getKey());
        }

        // Loop to check for duplicate slugs
        // If a duplicate is found, append a suffix and check again
        while ($query->count() > 0) {
            // Append the separator and counter to the base slug to create a new slug
            $slug = $baseSlug.$options->separator().$i++;
            // Update the query to check for the new slug
            $query->where($options->to(), $slug);
        }

        // Return the unique slug
        return $slug;
    }

    abstract public function getSlugOptions(): SlugOptions;
}

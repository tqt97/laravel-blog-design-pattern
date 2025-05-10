<?php

namespace App\Models;

use App\Contracts\SupportOneImage;
use App\Supports\SlugOptions;
use App\Traits\HasOneImage;
use App\Traits\HasSlug;
use App\Traits\HasSlugRedirects;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model implements SupportOneImage
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    use HasOneImage;
    use HasSlug;
    use HasSlugRedirects;

    protected $fillable = ['name', 'slug', 'parent_id', 'order', 'is_active'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the options for generating slugs for the current model.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->useSeparator('-')
            ->generateUniqueSlugs() // generate unique slugs
            ->allowSlugOverwrite(true); // allow slug overwrite when updating
    }

    /**
     * @return BelongsTo<\App\Models\Category, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * @return HasMany<\App\Models\Category, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Scope a query to only include categories that are parent categories.
     *
     * This scope will return categories where the parent_id is null.
     */
    public function scopeParent(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope a query to only include categories that are children of the given parent category.
     *
     * This scope will return categories where the parent_id matches the given $parentId.
     */
    public function scopeChildrenOf(Builder $query, int $parentId): Builder
    {
        return $query->where('parent_id', $parentId);
    }

    /**
     * Scope a query to only include categories that match the given filters.
     *
     * This scope will filter categories based on the given $filters array.
     * The following filters are supported:
     *
     * - search: Search categories by name, slug, or description.
     * - sort_by: Sort categories by name, slug, created_at, or updated_at.
     * - sort_dir: Sort categories in ascending (asc) or descending (desc) order.
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        if (! empty($filters['search'])) {
            $query->whereLike('name', '%'.$filters['search'].'%');
        }

        $sortable = ['name', 'slug', 'created_at', 'updated_at'];
        $directions = ['asc', 'desc'];

        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortDir = $filters['sort_dir'] ?? 'desc';

        if (in_array($sortBy, $sortable) && in_array($sortDir, $directions)) {
            $query->orderBy($sortBy, $sortDir);
        }

        return $query;
    }

    /**
     * Get the status label based on the 'is_active' field.
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->is_active ? __('common.status.active') : __('common.status.inactive');
    }

    /**
     * Get the status badge classes based on the 'is_active' field.
     */
    public function getStatusBadgeClassesAttribute(): string
    {
        return $this->is_active
            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
            : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
    }
}

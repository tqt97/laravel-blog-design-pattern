<?php

namespace App\Supports;

class SlugOptions
{
    protected string $from;

    protected string $to;

    protected string $separator;

    protected bool $unique;

    protected bool $allowOverwriteOnUpdate;

    public function __construct(
        ?string $from = null,
        ?string $to = null,
        ?string $separator = null,
        ?bool $unique = null,
        ?bool $allowOverwriteOnUpdate = null
    ) {
        $this->from = $from ?? config('slug.defaults.from', 'title');
        $this->to = $to ?? config('slug.defaults.to', 'slug');
        $this->separator = $separator ?? config('slug.defaults.separator', '-');
        $this->unique = $unique ?? config('slug.defaults.unique', true);
        $this->allowOverwriteOnUpdate = $allowOverwriteOnUpdate ?? config('slug.defaults.overwrite_on_update', true);
    }

    public static function create(): self
    {
        return new self;
    }

    /**
     * Set the field from which slugs will be generated.
     *
     * @param  string  $field  The field name to generate slugs from.
     * @return $this
     */
    public function generateSlugsFrom(string $field): self
    {
        $this->from = $field;

        return $this;
    }

    /**
     * Set the field where the generated slugs will be saved.
     *
     * @param  string  $field  The field name to save slugs to.
     * @return $this
     */
    public function saveSlugsTo(string $field): self
    {
        $this->to = $field;

        return $this;
    }

    /**
     * Set the separator used in generated slugs.
     *
     * @param  string  $separator  The separator to use. Defaults to a dash (-).
     * @return $this
     */
    public function useSeparator(string $separator): self
    {
        $this->separator = $separator;

        return $this;
    }

    /**
     * Indicates that generated slugs should be unique.
     *
     * @return $this
     */
    public function generateUniqueSlugs(): self
    {
        $this->unique = true;

        return $this;
    }

    /**
     * Indicates that generated slugs should not be unique.
     *
     * @return $this
     */
    public function doNotGenerateUniqueSlugs(): self
    {
        $this->unique = false;

        return $this;
    }

    /**
     * Allow slugs to be overwritten when the model is updated.
     *
     * @param  bool  $allow  Whether to allow slug overwriting. Defaults to true.
     * @return $this
     */
    public function allowSlugOverwrite(bool $allow = true): self
    {
        $this->allowOverwriteOnUpdate = $allow;

        return $this;
    }

    /**
     * Get the field or fields that the slug should be generated from.
     *
     * @return string|array The field(s) to generate the slug from.
     */
    public function from(): string
    {
        return $this->from;
    }

    /**
     * Get the field where the generated slugs will be saved.
     *
     * @return string The field name to save slugs to.
     */
    public function to(): string
    {
        return $this->to;
    }

    /**
     * Get the separator used to generate slugs.
     *
     * @return string The separator used to generate slugs.
     */
    public function separator(): string
    {
        return $this->separator;
    }

    /**
     * Determine if the generated slugs should be unique.
     *
     * @return bool True if slugs should be unique, false otherwise.
     */
    public function shouldBeUnique(): bool
    {
        return $this->unique;
    }

    /**
     * Check if slugs can be overwritten when the model is updated.
     *
     * @return bool True if overwriting is allowed, false otherwise.
     */
    public function allowOverwriteOnUpdate(): bool
    {
        return $this->allowOverwriteOnUpdate;
    }
}

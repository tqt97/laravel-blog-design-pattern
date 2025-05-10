<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = [
        'imageable_type',
        'imageable_id',
        'disk',
        'path',
        'url',
        'mime_type',
        'size',
        'alt_text',
        'is_default',
        'order',
        'collection',
    ];

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
            'order' => 'integer',
        ];
    }

    /**
     * The model that the image belongs to.
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the URL of the image from storage.
     */
    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }
}

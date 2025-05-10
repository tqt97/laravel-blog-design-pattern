<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface SupportManyImages
{
    public function images(): MorphMany;

    public function getImageUrlAttribute(): ?string;
}

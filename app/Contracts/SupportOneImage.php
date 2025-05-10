<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphOne;

interface SupportOneImage
{
    public function image(): MorphOne;

    public function getImageUrlAttribute(): ?string;
}

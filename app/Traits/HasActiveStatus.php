<?php

namespace App\Traits;

trait HasActiveStatus
{
    public function getStatusLabelAttribute(): string
    {
        return $this->is_active ? __('common.status.active') : __('common.status.inactive');
    }

    public function getStatusBadgeClassesAttribute(): string
    {
        return $this->is_active
            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
            : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
    }
}

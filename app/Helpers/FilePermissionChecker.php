<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FilePermissionChecker
{
    /**
     * Determine if the specified path on the given disk is writable.
     */
    public static function canWrite(string $disk, string $path): bool
    {
        $fullPath = Storage::disk($disk)->path($path);

        if (! File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }

        return is_dir($fullPath) && is_writable($fullPath);
    }

    /**
     * Determine if the specified path on the given disk is readable.
     */
    public static function canRead(string $disk, string $path): bool
    {
        $fullPath = Storage::disk($disk)->path($path);

        return is_dir($fullPath) && is_readable($fullPath);
    }
}

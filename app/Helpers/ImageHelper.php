<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class ImageHelper
{
    /**
     * Store the uploaded file and return the file path.
     *
     * @return string The file path of the uploaded image
     */
    public static function store(UploadedFile $file, string $collection, string $disk = 'public'): string
    {
        $folder = self::resolveFolder($collection);
        // self::ensureWritable($disk, $folder);

        $filename = self::generateFileName($file);

        return Storage::disk($disk)->putFileAs($folder, $file, $filename);
    }

    /**
     * Delete a single file from storage.
     */
    public static function delete(string $path, string $disk = 'public'): bool
    {
        return Storage::disk($disk)->exists($path) && Storage::disk($disk)->delete($path);
    }

    /**
     * Delete multiple files from storage.
     *
     * @throws RuntimeException
     */
    public static function deleteMany(array $paths, string $disk = 'public'): void
    {
        foreach ($paths as $path) {
            self::delete($path, $disk);
        }
    }

    /**
     * Ensure the folder is writable.
     *
     * @throws RuntimeException
     */
    protected static function ensureWritable(string $disk, string $folder): void
    {
        throw_if(! Storage::disk($disk)->exists($folder) || ! is_writable(Storage::disk($disk)->path($folder)), RuntimeException::class, "Cannot write to folder: {$folder}");
    }

    /**
     * Generate a unique filename for the uploaded file.
     */
    protected static function generateFileName(UploadedFile $file): string
    {
        return Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'-'.uniqid().'.'.$file->getClientOriginalExtension();
    }

    /**
     * Resolve the folder path for the given collection.
     *
     * @return string The folder path
     */
    protected static function resolveFolder(string $collection): string
    {
        return config('media.paths.images', 'images').'/'.$collection;
    }
}

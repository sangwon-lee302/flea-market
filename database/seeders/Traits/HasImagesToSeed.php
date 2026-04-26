<?php

namespace Database\Seeders\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait HasImagesToSeed
{
    protected function copyImageToStorage(string $filename, string $subDir = ''): string
    {
        $sourcePath = database_path("seeders/images/{$filename}");
        $destPath   = "{$subDir}/{$filename}";

        if (File::exists($sourcePath)) {
            Storage::disk('public')->put($destPath, File::get($sourcePath));
        }

        return $destPath;
    }
}

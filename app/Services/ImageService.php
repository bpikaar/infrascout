<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImageService
{
    /**
     * Process an image (resize, convert to JPG) and store it.
     *
     * @param UploadedFile $file The uploaded image file.
     * @param string $directory The directory to store the image in.
     * @param string $disk The storage disk to use (default: 'local').
     * @return string The generated filename.
     */
    public static function processAndStore(UploadedFile $file, string $directory, string $disk = 'local'): string
    {
        $imageToProcess = Image::read($file);
        $filename = uniqid() . '.jpg';

        $directory = rtrim($directory, '/');
        $path = $directory . '/' . $filename;

        $imageToProcess->scaleDown(config('image.scale'), config('image.scale'));
        Storage::disk($disk)->put($path, $imageToProcess->encodeByExtension('jpg', quality: config('image.quality')));

        return $filename;
    }
}

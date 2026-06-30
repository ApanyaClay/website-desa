<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageHelper
{
    /**
     * Convert and compress an uploaded image to webp format using native PHP GD library.
     *
     * @param UploadedFile $file The uploaded file
     * @param string $folder The destination folder inside storage/app/public/
     * @param int $quality Compression quality (0-100)
     * @param int|null $maxWidth Max width to resize to (maintains aspect ratio)
     * @return string|null The relative file path inside public storage (e.g. 'logos/xyz.webp'), or null on failure
     */
    public static function convertToWebp(UploadedFile $file, string $folder = 'uploads', int $quality = 80, ?int $maxWidth = 1200): ?string
    {
        try {
            $realPath = $file->getRealPath();
            if (!$realPath || !file_exists($realPath)) {
                return null;
            }

            $imageContent = file_get_contents($realPath);
            $srcImage = @imagecreatefromstring($imageContent);
            if (!$srcImage) {
                return null;
            }

            // Get original dimensions
            $width = imagesx($srcImage);
            $height = imagesy($srcImage);

            // Resize if exceeds max width to save space
            if ($maxWidth && $width > $maxWidth) {
                $newWidth = $maxWidth;
                $newHeight = (int) (($height / $width) * $maxWidth);

                $destImage = imagecreatetruecolor($newWidth, $newHeight);

                // Preserve alpha channel (transparency) for PNGs/WebPs
                imagealphablending($destImage, false);
                imagesavealpha($destImage, true);

                imagecopyresampled(
                    $destImage,
                    $srcImage,
                    0, 0, 0, 0,
                    $newWidth, $newHeight,
                    $width, $height
                );

                imagedestroy($srcImage);
                $srcImage = $destImage;
            } else {
                // If not resizing, we still ensure transparency is handled if needed
                imagealphablending($srcImage, false);
                imagesavealpha($srcImage, true);
            }

            // Create temporary path to save webp file
            $tempFile = tempnam(sys_get_temp_dir(), 'webp_');
            if ($tempFile === false) {
                return null;
            }

            // Convert to webp
            $webpSuccess = imagewebp($srcImage, $tempFile, $quality);
            imagedestroy($srcImage);

            if (!$webpSuccess) {
                @unlink($tempFile);
                return null;
            }

            // Generate unique filename
            $filename = Str::random(40) . '.webp';
            $relativePath = $folder . '/' . $filename;
            
            // Store the file in Laravel's public storage disk
            Storage::disk('public')->put($relativePath, file_get_contents($tempFile));
            @unlink($tempFile);

            return $relativePath;
        } catch (\Exception $e) {
            \Log::error('Image webp conversion failed: ' . $e->getMessage());
            return null;
        }
    }
}

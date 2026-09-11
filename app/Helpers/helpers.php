<?php

if (!function_exists('karakopo_image_url')) {
    /**
     * Resolve any image path or URL safely with fallback
     */
    function karakopo_image_url(?string $path): string
    {
        if (empty($path)) {
            return asset('images/logo.png');
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, '/storage/') || str_starts_with($path, 'storage/')) {
            return asset(ltrim($path, '/'));
        }

        return asset('storage/' . ltrim($path, '/'));
    }
}

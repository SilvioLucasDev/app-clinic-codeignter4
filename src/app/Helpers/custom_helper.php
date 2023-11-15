<?php

use App\Exceptions\UploadImageException;
use CodeIgniter\HTTP\Files\UploadedFile;
use Config\Services;

if (!function_exists('display_error')) {
    function display_error(string $field): string
    {
        return session()->get('errors')[$field] ?? '';
    }
}

if (!function_exists('sanitize_number')) {
    function sanitize_number(string $number): string
    {
        return preg_replace("/[^0-9]/", "", $number);
    }
}

if (!function_exists('upload_image')) {
    function upload_image(UploadedFile $image, string $path): string|Exception
    {
        if (!$image->isValid()) throw new UploadImageException();

        $imageName = $image->getRandomName();
        $uploaded = Services::image('gd')
            ->withFile($image)
            ->fit(150, 150)
            ->save(FCPATH . "$path/$imageName", 100);

        if (!$uploaded) throw new UploadImageException();

        return "$path/$imageName";
    }
}

if (!function_exists('remove_image')) {
    function remove_image(string $imagePath): void
    {
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
}

<?php

use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\HTTP\RedirectResponse;
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
    function upload_image(UploadedFile $image, string $path): string|bool
    {
        $imageName = $image->getRandomName();
        $uploaded = Services::image('gd')
            ->withFile($image)
            ->fit(150, 150)
            ->save(FCPATH . "$path/$imageName", 100);

        if (!$uploaded) return false;

        return "$path/$imageName";
    }
}

if (!function_exists('remove_image')) {
    function remove_image(string $imagePath): void
    {
        if (isset($imagePath)) {
            unlink($imagePath);
        }
    }
}

if (!function_exists('handle_response')) {
    function handle_response(string $type, string $message, string $route, array $params = null): RedirectResponse
    {
        return redirect()->route($route, $params ?? [])->withInput()->with('message', ['type' => $type, 'text' => $message]);
    }
}

<?php
if (!function_exists('custom_public_path')) {
    function custom_public_path($path = '')
    {
        return app()->basePath('public') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('public_path')) {
    function public_path($path = '')
    {
        return app()->basePath('public') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
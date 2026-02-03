<?php
if (!function_exists('custom_public_path')) {
    function custom_public_path($path = '')
    {
        return app()->basePath('public') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
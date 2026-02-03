<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use App\Models\Setting;

class AppSetting
{
    // Ambil data setting dari cache atau database
    public static function getSetting()
    {
        return Cache::rememberForever('app_setting', function () {
            return Setting::first(); // diasumsikan hanya 1 baris setting
        });
    }

    // Ambil nama aplikasi
    public static function name()
    {
        return self::getSetting()?->system_name ?? 'Membership App';
    }

    // Ambil logo aplikasi (url ke asset)
    public static function logo($fullPath = false)
    {
        $logo = self::getSetting()?->logo;

        if (!$logo) {
            return asset('uploads/default-logo.png'); // fallback jika logo kosong
        }

        return $fullPath
            ? public_path('uploads/logo/' . $logo)
            : asset('uploads/logo/' . $logo);
    }

    public static function webbg($fullPath = false)
    {
        $webbg = self::getSetting()?->webbg;

        if (!$webbg) {
            return asset('uploads/rm-wall-bg.png'); // fallback jika logo kosong
        }

        return $fullPath
            ? public_path('uploads/webbg/' . $webbg)
            : asset('uploads/webbg/' . $webbg);
    }

    // Hapus cache jika setting diubah
    public static function resetCache()
    {
        Cache::forget('app_setting');
    }
}

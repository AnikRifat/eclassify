<?php

namespace App\Services;

use App\Models\Language;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class CachingService {

    /**
     * @param $key
     * @param callable $callback - Callback function must return a value
     * @param int $time = 3600
     * @return mixed
     */
    public static function cacheRemember($key, callable $callback, int $time = 3600) {
        return Cache::remember($key, $time, $callback);
    }

    public static function removeCache($key) {
        Cache::forget($key);
    }

    /**
     * @param array|string $key
     * @return mixed|string
     */
    public static function getSystemSettings(array|string $key = '*') {
        $settings = self::cacheRemember(config('constants.CACHE.SETTINGS'), static function () {
            return Setting::all()->pluck('value', 'name');
        });

        if (($key != '*')) {
            /* There is a minor possibility of getting a specific key from the $systemSettings
             * So I have not fetched Specific key from DB. Otherwise, Specific key will be fetched here
             * And it will be appended to the cached array here
             */
            $specificSettings = [];

            // If array is given in Key param
            if (is_array($key)) {
                foreach ($key as $row) {
                    if ($settings && is_array($settings) && array_key_exists($row, $settings)) {
                        $specificSettings[$row] = $settings[$row] ?? '';
                    }
                }
                return $specificSettings;
            }

            // If String is given in Key param
            if ($settings && is_object($settings) && $settings->has($key)) {
                return $settings[$key] ?? '';
            }

            return "";
        }
        return $settings;
    }

    public static function getLanguages() {
        return self::cacheRemember(config('constants.CACHE.LANGUAGE'), static function () {
            return Language::all();
        });
    }
}

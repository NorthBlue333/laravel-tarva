<?php

namespace LaravelAdmin;

use LaravelAdmin\Resources\Resource;

class Utils {
    public static function getResourceClasses(): array {
        $classes = [];
        foreach (glob(config('laravel-admin.resource.folder', app_path() . '/Admin/Resources/*.php')) as $file) {
            $basename = basename($file, '.php');
            if($basename === 'Resource') continue;
            $class = config('laravel-admin.resource.namespace', '\App\Admin\Resources\\') . $basename;
            array_push($classes, $class);
        }
        return $classes;
    }

    public static function findResource(string $uriKey): string {
        return collect(static::getResourceClasses())->first(fn ($class) => $class::uriKey() === $uriKey);
    }
}

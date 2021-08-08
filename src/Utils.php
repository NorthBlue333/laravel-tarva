<?php

namespace LaravelTarva;

use Illuminate\Support\Facades\Storage;

class Utils {
    public static function getResourceClasses(): array {
        return static::_findClassesFromGlob(
            config('laravel-tarva.resources.directory', 'Tarva/Resources'),
            config('laravel-tarva.resources.regex', "/^.*\.php$/"),
            config('laravel-tarva.resources.namespace', '\App\Tarva\Resources\\'),
        );
    }

    public static function getPageClasses(): array {
        return static::_findClassesFromGlob(
            config('laravel-tarva.pages.directory', 'Tarva/Pages'),
            config('laravel-tarva.pages.regex', "/^(?!web\.php).*\.php/"),
            config('laravel-tarva.pages.namespace', '\App\Tarva\Pages\\'),
        );
    }

    public static function getPageRoutes(): array {
        $rootPath = app_path(config('laravel-tarva.pages.directory', 'Tarva/Pages'));
        $disk = Storage::build([
            'driver' => 'local',
            'root' => $rootPath,
        ]);
        return array_map(
            fn ($file) => Storage::path($rootPath . '/' . $file),
            array_filter(
                $disk->allFiles(),
                fn ($file) => preg_match(config('laravel-tarva.pages.routeRegex', "/^web.*\.php/"), $file)
            ),
        );
    }

    public static function findResource(string $uriKey): string {
        return collect(static::getResourceClasses())->first(fn ($class) => $class::uriKey() === $uriKey);
    }

    public static function findPage(string $uriKey): string {
        return collect(static::getPageClasses())->first(fn ($class) => $class::uriKey() === $uriKey);
    }

    private static function _findClassesFromGlob(string $directory, string $regex, string $namespace): array {
        $disk = Storage::build([
            'driver' => 'local',
            'root' => app_path($directory),
        ]);
        $classes = [];
        foreach ($disk->allFiles() as $file) {
            if(!preg_match($regex, $file)) continue;

            $currentPath = $file;
            $basename = basename($file, '.php');
            while(dirname($currentPath) !== '.') {
                $currentPath = dirname($currentPath);
                $basename = basename($currentPath) . '\\' . $basename;
            }
            $class = $namespace . $basename;
            array_push($classes, $class);
        }
        return $classes;
    }
}

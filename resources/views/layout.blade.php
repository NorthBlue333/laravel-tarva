<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <link rel="stylesheet"
            href="{{ asset('vendor/laravel-tarva/css/tarva.css') }}">
        <script src="https://kit.fontawesome.com/da505524df.js"
                crossorigin="anonymous"></script>
        @routes
        <script src="{{ asset('vendor/laravel-tarva/js/tarva.js') }}" defer></script>
    </head>

    <body class="bg-gray-50">
        @inertia
        {{-- <x-laravel-tarva-navigation contentId="admin-main-content"
                            classesToToggle="pl-24 pl-12">
            @slot('userTitle')
                {{ auth()->user()->email }}
            @endslot
        </x-laravel-tarva-navigation>
        <main class="pl-24 pt-16 pr-8 pb-8 w-full transition-p-w duration-200"
            id="admin-main-content">
            @yield('content')
        </main> --}}
    </body>
</html>

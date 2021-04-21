<nav class="pl-20 py-2 fixed top-0 bg-gray-lighter w-full transition-size duration-200"
     x-data="{lockNav: window.__laraveladmin_navigation_dispatchLockNav}">
    <button class="block text-center text-gray-dark focus:outline-none hover:text-tertiary transition-colors duration-200"
            data-instant-toggle="text-center,text-right"
            x-on:click="lockNav($dispatch, $event)">
        <i class="fas fa-arrow-right"></i>
    </button>
</nav>

<nav class="min-h-screen bg-gray-dark flex flex-col text-ghost-white w-16 overflow-hidden transition-size duration-200 fixed z-40 top-0 flex-shrink-0"
     x-data="{isLocked: false, isClosed: true, toggleNav: window.__laraveladmin_navigation_toggleNav, lockNav: window.__laraveladmin_navigation_lockNav}"
     x-on:mouseenter="toggleNav($event.target)"
     x-on:mouseleave="toggleNav($event.target)"
     x-on:lock-nav.window="
        lockNav({{ $contentId ? "'" . $contentId . "'" : null }},
        {{ $classesToToggle ? "'" . $classesToToggle . "'" : null }})
">
    <div class="text-tertiary w-full h-52 text-center p-2 flex flex-col items-center justify-center flex-shrink-0">
        <i class="far fa-user-circle text-3xl transition-size duration-200 block w-full pt-2"
           x-ref="profile"></i>
        @if (isset($userTitle) && $userTitle)
            <p class="font-bold pt-4 opacity-0 transition-opacity duration-200"
               data-toggle="opacity-0">
                {{ $userTitle }}
            </p>
        @endif
        <form class="opacity-75"
              action="{{ route('logout') }}"
              method="POST">
            @csrf
            <button class="px-2 py-1 hover:underline"
                    type="submit">
                <i class="fas fa-sign-out-alt"></i>
                <span class="ml-2 opacity-0 transition-opacity duration-200"
                      data-toggle="opacity-0">Déconnexion</span>
            </button>
        </form>
    </div>
    <ul class="flex flex-col h-full pt-4 text-ghost-white">
        <li>
            <a class="py-2 px-4 block group hover:opacity-75 text-center transition duration-200"
               href="{{ route('laravel-admin::home') }}"
               data-instant-toggle="text-center">
                <i class="fas fa-home tex"></i>
                <span class="pl-2 group-hover:pl-4 transition-all duration-200 opacity-0 hidden"
                      data-toggle="opacity-0,hidden">{{ __('Home') }}</span>
            </a>
        </li>
        <li class="py-2 px-4 uppercase opacity-75 text-center transition duration-200"
            data-instant-toggle="text-center">
            <i class="fas fa-stream"></i>
            <span class="pl-2 text-sm transition-opacity duration-200 opacity-0 hidden"
                  data-toggle="opacity-0,hidden">{{ __('Resources') }}</span>
        </li>
        @foreach (array_filter($adminResourceClasses, fn($class) => $class::$showInSidebar) as $sidebarResource)
            <li class="transition-size duration-200"
                data-toggle="pl-6">
                @if (Route::currentRouteName() === 'laravel-admin::resources.list' && isset(Route::getCurrentRoute()->parameters['resource']) && Route::getCurrentRoute()->parameters['resource'] === $sidebarResource::uriKey())
                    <p class="py-1 px-4 block opacity-75 text-center transition duration-200 font-bold"
                       href="{{ route('laravel-admin::resources.list', ['resource' => $sidebarResource::uriKey()]) }}"
                       data-instant-toggle="text-center">
                        @if ($sidebarResource::icon())
                            <i class="fas {{ $sidebarResource::icon() }}"></i>
                        @endif
                        <span class="pl-4 transition-all duration-200 opacity-0 hidden"
                              data-toggle="opacity-0,hidden">{{ $sidebarResource::plural() }}</span>
                    </p>
                @else
                    <a class="py-1 px-4 block group hover:opacity-75 text-center transition duration-200"
                       href="{{ route('laravel-admin::resources.list', ['resource' => $sidebarResource::uriKey()]) }}"
                       data-instant-toggle="text-center">
                        @if ($sidebarResource::icon())
                            <i class="fas {{ $sidebarResource::icon() }}"></i>
                        @endif
                        <span class="pl-2 group-hover:pl-4 transition-all duration-200 opacity-0 hidden"
                              data-toggle="opacity-0,hidden">{{ $sidebarResource::plural() }}</span>
                    </a>
                @endif
            </li>
        @endforeach
    </ul>
</nav>

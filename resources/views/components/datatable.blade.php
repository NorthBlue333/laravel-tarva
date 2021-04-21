<div class="rounded-md border border-gray-lighter overflow-hidden">
    <div class="py-4 px-4 flex" x-data="{route: '{{ route('laravel-admin::resources.list', [
        'resource' => $resourceClass::uriKey(),
        ]) }}',
        resourceIndexPageWithQuery: window.__laraveladmin_debounce(window.__laraveladmin_index_resourceIndexPageWithQuery, 500),
        changeIndexPageParameters: window.__laraveladmin_index_changeIndexPageParameters,
        indexPageParameters: {{ json_encode($filters) }},
        isFilterDropdownOpened: false
    }">
        <div class="ml-auto relative">
            <button class="text-gray-medium-light hover:text-tertiary bg-gray-lighter py-2 px-3 rounded-md"
                x-on:click="isFilterDropdownOpened = true"
            >
                <i class="fas fa-filter"></i>
            </button>
            <template x-if="isFilterDropdownOpened">
                <ul class="absolute top-full right-0 bg-ghost-white shadow rounded-md border-gray-light border min-w-32 text-gray-medium"
                    x-ref="dropdown"
                    x-on:click.away="isFilterDropdownOpened = false"
                >
                    <li class="bg-gray-lighter border-b border-gray-light">
                        <button class="uppercase font-bold text-xs w-full p-2">Reset filters</button>
                    </li>
                    <li class="p-2 uppercase font-bold text-sm bg-gray-lighter">Per page</li>
                    <li class="p-2">
                        @foreach ($filtersOptions as $filterName => $filterOptions)
                            @if($filterOptions['type'] === 'select')
                                <select class="w-full" x-on:change="changeIndexPageParameters('{{ $filterName }}', $event.target.value)">
                                    @foreach ($filterOptions['values'] as $filterOption)
                                        <option @if($filters[$filterName] === $filterOption) selected @endif>{{ $filterOption }}</option>
                                    @endforeach
                                </select>
                            @endif
                        @endforeach
                    </li>
                </ul>
            </template>
        </div>
    </div>
    <table class="w-full">
        <thead
               class="bg-gray-lightest text-gray-medium font-semibold uppercase text-xs border-b border-t border-gray-lighter">
            <tr>
                <td class="py-2 px-4 w-16 text-right"></td>
                @foreach ($fields as $field)
                    @if ($field instanceof \LaravelAdmin\Fields\Panel)
                        @foreach ($field->getFields() as $subField)
                            <td class="py-2 px-4">{{ $subField->name }}</td>
                        @endforeach
                    @else
                        <td class="py-2 px-4">{{ $field->name }}</td>
                    @endif
                @endforeach
                <td class="py-2 px-4 w-32 text-right">Actions</td>
            </tr>
        </thead>
        <tbody class="text-gray font-light">
            @forelse ($resources as $resourceItem)
                <tr class="border-b border-gray-lighter hover:bg-gray-lightest"
                    x-data="{}">
                    <td class="py-3 px-4 text-center">
                        <input type="checkbox"
                               class="rounded-md shadow-checkbox focus:outline-none focus:shadow-outline checked:shadow-none
                                                    bg-white w-5 h-5 appearance-none checked:bg-tertiary checked:bg-checkbox align-middle">
                    </td>
                    @foreach ($resourceItem->getFields() as $field)
                        @if ($field instanceof \LaravelAdmin\Fields\Panel)
                            @foreach ($field->getFields() as $subField)
                                <td class="py-3 px-4">{!! $subField->getValueForDisplay() !!}</td>
                            @endforeach
                        @else
                            <td class="py-3 px-4">{!! $field->getValueForDisplay() !!}</td>
                        @endif
                    @endforeach
                    <td class="py-3 px-4 text-right text-gray-medium-light">
                        <a class="hover:text-tertiary text-lg px-1"
                           href="{{ route('laravel-admin::resources.show', [
    'resource' => $resourceClass::uriKey(),
    'id' => $resourceItem->getModel()->getKey(),
]) }}">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a class="hover:text-tertiary text-lg px-1"
                           href="{{ route('laravel-admin::resources.edit', [
    'resource' => $resourceClass::uriKey(),
    'id' => $resourceItem->getModel()->getKey(),
]) }}">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr class="border-b border-gray-lighter">
                    <td>
                        {{ __('No :resource', ['resource' => strtolower($resource::singular())]) }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <nav class="text-gray-light">
        <ul class="p-4 flex justify-between">
            <li class="font-bold">
                @if ($navigationLinks['previous'])
                    <a href="{{ $navigationLinks['previous'] }}">Previous</a>
                @else
                    <span class="text-gray-lighter cursor-not-allowed">Previous</span>
                @endif
            </li>
            <li>{{ ($currentPage - 1) * $perPage + 1 }}-{{ ($currentPage - 1) * $perPage + $resources->count() }} on
                {{ $resourceCount }}</li>
            <li class="font-bold">
                @if ($navigationLinks['next'])
                    <a href="{{ $navigationLinks['next'] }}">Next</a>
                @else
                    <span class="text-gray-lighter cursor-not-allowed">Next</span>
                @endif
            </li>
        </ul>
    </nav>
</div>

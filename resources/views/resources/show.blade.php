@extends('laravel-admin::layout')
@section('content')
    <div class="text-gray">
        <div class="flex">
            <h2 class="text-2xl font-semibold mb-4">
                {{ __(':resource Details: :title', [
                        'resource' => $resourceInstance::singular(),
                        'title' => $resourceInstance->title(),
                    ]) }}
            </h2>
            <ul class="ml-auto">
                <li>
                    <a class="text-gray-medium-light hover:text-tertiary bg-gray-lighter py-2 px-3 rounded-md shadow"
                       href="{{ route('laravel-admin::resources.edit', [
                                'resource' => $resourceInstance::uriKey(),
                                'id' => $resourceInstance->getModel()->getKey(),
                            ]) }}">
                        <i class="fas fa-edit"></i>
                    </a>
                </li>
            </ul>
        </div>
        @foreach ($panels as $panel)
            <section>
                @if ($panel->showTitle)
                    <h3 class="mt-6 mb-2 font-semibold text-lg">{{ $panel->name }}</h3>
                @endif
                <div class="shadow rounded-md border border-gray-lighter bg-white @if (!$panel->showTitle) mt-6 @endif">
                    @foreach ($panel->getFields() as $field)
                        <x-dynamic-component :component="'laravel-admin::fields.' . $field->getComponentType() . '.field'"
                                             :field="$field"
                                             class="mt-4" />
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>
@endsection

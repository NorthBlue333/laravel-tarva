@extends('laravel-admin::layout')
@section('content')
    <form class="text-gray"
          method="POST"
          action="{{ route('laravel-admin::resources.update', [
            'resource' => $resourceInstance::uriKey(),
            'id' => $resourceInstance->getModel()->getKey(),
        ]) }}"
          enctype="multipart/form-data"
        >
        @csrf
        <h2 class="text-2xl font-semibold mb-4">{{ __(':resource Details: :title', [
                'resource' => $resourceInstance::singular(),
                'title' => $resourceInstance->title(),
            ]) }}</h2>
        @foreach ($panels as $panel)
            <section>
                @if ($panel->showTitle)
                    <h3 class="mt-6 mb-2 font-semibold text-lg">{{ $panel->name }}</h3>
                @endif
                <div class="shadow rounded-md border border-gray-lighter bg-white @if (!$panel->showTitle) mt-6 @endif">
                    @foreach ($panel->getFields() as $field)
                        <x-dynamic-component :component="'laravel-admin::fields.' . $field->getComponentType() . '.field'"
                                             :field="$field" />
                    @endforeach
                </div>
            </section>
        @endforeach
        <div class="mt-4 flex justify-end">
            <button class="bg-tertiary hover:bg-tertiary-shadow text-ghost-white font-bold py-2 px-3 rounded-md shadow order-2"
                    type="submit"
                    name="__submit-redirect"
                    value="laravel-admin::resources.show">
                {{ __('Save and quit') }}
            </button>
            <button class="text-gray-medium-light hover:bg-gray-lighter bg-gray-lightest py-2 px-3 rounded-md shadow font-bold mr-4 order-1"
                    type="submit"
                    name="__submit-redirect"
                    value="laravel-admin::resources.edit">
                {{ __('Save and continue') }}
            </button>
        </div>
    </form>
@endsection

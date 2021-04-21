@extends('laravel-admin::layout')
@section('content')
    <div class="text-gray">
        <h2 class="text-2xl font-semibold mb-4">{{ $resource::plural() }}</h2>
        <x-laravel-admin-datatable :resources="$resources"
                           :resourceCount="$resourceCount"
                           :navigationLinks="$navigationLinks"
                           :currentPage="$currentPage"
                           :perPage="$perPage"
                           :resourceClass="$resource"
                           :filters="$filters"
                           :filtersOptions="$filtersOptions"
                           :filtersDefaults="$filtersDefaults" />
    </div>
@endsection

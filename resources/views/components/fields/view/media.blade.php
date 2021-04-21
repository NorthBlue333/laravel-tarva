<div class="flex flex-wrap p-3 justify-end">
    <div class="text-gray-medium-light w-1/4">
        {{ $field->name }}
    </div>
    <div class="w-3/4">
        <div class="flex flex-wrap items-center">
            @foreach($field->getValueForDisplay() as $media)
                <picture
                    class="w-48 h-48 flex items-center justify-center shadow rounded border border-tertiary border-opacity-50 m-2"
                >
                    <img class="max-w-full max-h-full" alt="" src="{{ asset($media->getFullUrl()) }}">
                </picture>
            @endforeach
        </div>
    </div>
    @if($field->helper)
        <p class="w-3/4 mt-1 italic text-sm text-gray-medium-light">
            {{ $field->helper }}
        </p>
    @endif
</div>

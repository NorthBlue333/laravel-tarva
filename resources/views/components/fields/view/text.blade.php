<div class="flex flex-wrap p-3 items-center justify-end">
    <div class="text-gray-medium-light w-1/4">
        {{ $field->name }}
    </div>
    <div class="w-3/4">
        {{ $field->getValueForDisplay() }}
    </div>
    @if($field->helper)
        <p class="w-3/4 mt-1 italic text-sm text-gray-medium-light">
            {{ $field->helper }}
        </p>
    @endif
</div>

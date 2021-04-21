<div class="flex flex-wrap p-3">
    <div class="text-gray-medium-light w-1/4">
        {{ $field->name }}
    </div>
    <textarea class="w-3/4">{{ $field->getValue() }}</textarea>
    @if($field->helper)
        <p class="w-full">
            {{ $field->helper }}
        </p>
    @endif
</div>

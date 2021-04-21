<div class="flex flex-wrap p-3 items-center justify-end">
    <label for="{{ $field->getAttribute() }}"
           class="text-gray-medium-light w-1/4">
        {{ $field->name }}
        @if ($field->isRequired())
            <span class="text-sm">*</span>
        @endif
    </label>
    <input class="w-3/4 @error($field->getAttribute()) is-invalid @enderror"
           value="{{ old($field->getAttribute()) ?? $field->getValue() }}"
           name="{{ $field->getAttribute() }}"
           id="{{ $field->getAttribute() }}"
           @foreach ($field->getMetadata() as $key => $value)
    {{ $key . '=' . $value . '' }}
    @endforeach
    />
    @if ($field->helper)
        <p class="w-3/4 mt-1 italic text-sm text-gray-medium-light">
            {{ $field->helper }}
        </p>
    @endif
    @if ($errors->has($field->getAttribute()))
        @foreach ($errors->get($field->getAttribute()) as $message)
            <p class="w-3/4 mt-1 italic text-sm text-red">
                {{ $message }}
            </p>
        @endforeach
    @endif
</div>

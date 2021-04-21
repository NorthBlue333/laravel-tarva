<div class="flex flex-wrap p-3 items-center justify-end">
    <label for="{{ $field->getAttribute() }}"
           class="text-gray-medium-light w-1/4">
        {{ $field->name }}
        @if ($field->isRequired())
            <span class="text-sm">*</span>
        @endif
    </label>
    <div
        x-data="{
            content: `{{ old($field->getAttribute()) ?? $field->getValue() }}`,
            setFieldValue: window.__laraveladmin_fields_wysiwyg_setFieldValue
        }"
        class="wysiwyg w-3/4 @error($field->getAttribute()) is-invalid @enderror"
    >
        <input value="{{ old($field->getAttribute()) ?? $field->getValue() }}"
            name="{{ $field->getAttribute() }}"
            id="{{ $field->getAttribute() }}"
            type="hidden"
            x-ref="field"
            x-model="content"
        />
        <alpine-editor
            x-model="content"
            @foreach($field->getHeadingClasses() as $heading => $classes)
                data-{{ $heading }}-classes="{{ $classes }}"
            @endforeach
        >
            <div data-type="menu" class="bg-gray-lighter wysiwyg-menu">
                <button
                    type="button"
                    data-command="strong"
                    data-active-class="wysiwyg-active"
                    class="text-black"
                >
                    <i class="fas fa-bold"></i>
                </button>
                <button
                    type="button"
                    data-command="em"
                    data-active-class="wysiwyg-active"
                    class="bg-gray-500"
                >
                    <i class="fas fa-italic"></i>
                </button>
                <button
                    type="button"
                    data-command="underline"
                    data-active-class="wysiwyg-active"
                    class="bg-gray-500"
                >
                    <i class="fas fa-underline"></i>
                </button>
                <button type="button"
                    data-command="heading"
                    data-level="3"
                    data-active-class="wysiwyg-active"
                >
                    <i class="fas fa-heading"></i>eading
                </button>
            </div>

            <div data-type="editor" class="p-2" x-on:input="setFieldValue">
            </div>
        </alpine-editor>
    </div>
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

@once
    @push('scripts')
        <script src="{{ asset('vendor/laravel-admin/js/admin-alpine-editor.js') }}"></script>
    @endpush
@endonce

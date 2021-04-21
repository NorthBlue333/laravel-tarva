<div class="flex flex-wrap p-3 items-center justify-end" x-data="{deleteMedia: window.__laraveladmin_fields_media_deleteMedia, addMedia: window.__laraveladmin_fields_media_addMedia}">
    <label for="{{ $field->getAttribute() }}"
           class="text-gray-medium-light w-1/4">
        {{ $field->name }}
        @if ($field->isRequired())
            <span class="text-sm">*</span>
        @endif
    </label>
    <input name="{{ $field->getAttribute() }}{{ $field->isMultiple() ? '[]' : '' }}"
           id="{{ $field->getAttribute() }}"
           type="file"
           x-on:change="addMedia($event)"
           @foreach ($field->getMetadata() as $key => $value)
    {{ $key . '=' . $value . '' }}
    @endforeach
    />
    <label class="w-3/4 cursor-pointer file-label @error($field->getAttribute()) is-invalid @enderror"
        for="{{ $field->getAttribute() }}">
        <span>Choose file(s)...</span>
        <span class="file-names" x-ref="file-names"></span>
    </label>
    <div class="w-3/4 mt-4 flex flex-wrap items-center" x-ref="media-list">
        @foreach($field->getValueForDisplay() as $media)
            <picture
                class="w-48 h-48 flex items-center justify-center shadow rounded border border-tertiary border-opacity-50 relative m-2"
                x-ref="existing-{{ $field->getAttribute() }}-{{ $media->getKey() }}-preview"
            >
                <img class="max-w-full max-h-full" alt="" src="{{ asset($media->getFullUrl()) }}">
                <div class="absolute top-0 left-0 w-full h-full bg-gray-medium opacity-0 hover:opacity-100 bg-opacity-25 transition-opacity duration-200">
                    <div class="flex justify-end items-center p-2">
                        <button
                            class="text-tertiary"
                            x-on:click.prevent="deleteMedia(['existing-{{ $field->getAttribute() }}-{{ $media->getKey() }}', 'existing-{{ $field->getAttribute() }}-{{ $media->getKey() }}-preview'])">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </picture>
        @endforeach
    </div>
    @foreach($field->getValue() as $media)
        <input
            type="hidden"
            name="existing-{{ $field->getAttribute() }}[]" value="{{ $media->getKey() }}"
            x-ref="existing-{{ $field->getAttribute() }}-{{ $media->getKey() }}"
        >
    @endforeach
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

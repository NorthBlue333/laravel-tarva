<div class="flex flex-wrap p-3 justify-end">
    <div class="text-gray-medium-light w-1/4">
        {{ $field->name }}
    </div>
    <div class="w-3/4" x-data="{shouldShowText: false}">
        <div x-show="shouldShowText">
            {!! $field->getValueForDisplay() !!}
        </div>
        <div>
            <button class="text-tertiary font-semibold focus:outline-none" x-on:click.prevent="shouldShowText = !shouldShowText">
                <span x-show="!shouldShowText">Afficher le texte</span>
                <span x-show="shouldShowText">Cacher le texte</span>
            </button>
        </div>
    </div>
    @if($field->helper)
        <p class="w-3/4 mt-1 italic text-sm text-gray-medium-light">
            {{ $field->helper }}
        </p>
    @endif
</div>

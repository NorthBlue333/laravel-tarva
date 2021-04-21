<div class="border-b border-gray-lighter last:border-0">
    <x-dynamic-component :component="'laravel-admin::fields.form.' . $field::kebabName()" :field="$field" />
</div>

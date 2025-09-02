@props([
    'initialValue' => '',
])

<div
    class="rounded-md shadow-sm"
    wire:ignore
    {{ $attributes }}
    x-data="{
        value: @entangle($attributes->wire('model')),
        isFocused() { return document.activeElement === this.$refs.trix },
    }"
    x-init="
        $refs.trix.editor.loadHTML(value);

        $watch('value', (newValue) => {
            if (!isFocused()) {
                $refs.trix.editor.loadHTML(newValue);
            }
        });
    "
    x-on:trix-change.debounce.500ms="value = $event.target.value"
>
    <input id="x" type="hidden" value="{{ $initialValue }}">
    <trix-editor x-ref="trix" input="x" class="form-textarea block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></trix-editor>
</div>
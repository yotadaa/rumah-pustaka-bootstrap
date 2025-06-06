@props(['id', 'name', 'value' => '', 'model'])

{{ $slot }}

<trix-toolbar id="{{ $id }}_toolbar"></trix-toolbar>

<trix-editor wire:model="{{ $model }}" id="{{ $id }}" input="{{ $id }}_input"
    toolbar="{{ $id }}_toolbar" {{ $attributes->merge(['class' => 'trix-content']) }}>
</trix-editor>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const trixEditor = document.getElementById("{{ $id }}");
        const hiddenInput = document.getElementById("{{ $id }}_input");

        trixEditor.addEventListener("trix-change", function() {
            hiddenInput.dispatchEvent(new Event('input', {
                bubbles: true
            }));
        });
    });
</script>

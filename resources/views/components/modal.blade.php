<!-- resources/views/components/modal.blade.php -->
<div class="modal fade" id="{{ $attributes['id'] }}" tabindex="-1" aria-labelledby="{{ $attributes['id'] }}Label"
    aria-hidden="true" wire:ignore>
    <div class="modal-dialog {{ $size ?? '' }}">
        <div class="modal-content">
            @isset($title)
                <div class="modal-header">
                    <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            @endisset
            <div class="modal-body">
                {{ $slot }}
            </div>
            @isset($footer)
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>

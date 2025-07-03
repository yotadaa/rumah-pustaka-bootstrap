<div>
    {{-- The toast container is always in the DOM, but hidden until needed --}}
    @if ($message)
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
            <div class="toast text-bg-{{ $message['mode'] }} border-0" role="alert" aria-live="assertive"
                aria-atomic="true" id="messageToast">
                <div class="d-flex">
                    <div class="toast-body">
                        {{-- Display the message from the component's public property --}}
                        {{ $message['message'] }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    // buatkan overlay loading memutar,
    // parent fixed w-100 h-100 overflow-hidden
    // buat dengan bootstrap


    @if ($loading)
        <div wire:loading
            class="position-fixed w-100 h-100 top-0 start-0 d-flex justify-content-center align-items-center"
            id="loadingOverlay" style="background-color: rgba(0, 0, 0, 0.5); z-index: 1060;">
            <div class="spinner-border text-light" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    @endif

    <script>
        // sesuaikan di sini degan livewire
        document.addEventListener('livewire:initialized', function() {
            // This listens for the event dispatched from the server
            Livewire.on('show-toast', (event) => {
                // Use a short delay to ensure Livewire has updated the DOM
                setTimeout(() => {
                    const toastEl = document.getElementById('messageToast');
                    if (toastEl) {
                        const toast = new bootstrap.Toast(toastEl, {
                            delay: 3000 // 3 seconds
                        });
                        toast.show();

                        // Optional: Reset the message after the toast hides
                        toastEl.addEventListener('hidden.bs.toast', () => {
                            @this.set('message', null);
                        });
                    }
                }, 100);
            });

            // This listens for the event dispatched from the server
            Livewire.on('show-loading', () => {
                @this.set('loading', false);
            });
        });
    </script>
</div>

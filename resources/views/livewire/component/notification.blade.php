<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}

    @if (session()->has('message'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
            <div class="toast text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true"
                id="messageToast">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('message') }}
                        {{ $message }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('show-toast', () => {
                const toastEl = document.getElementById('messageToast');
                if (toastEl) {
                    const toast = new bootstrap.Toast(toastEl, {
                        delay: 2000
                    });
                    toast.show();
                }
            });
        });
    </script>





    {{-- <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
        <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive"
            aria-atomic="true" id="errorToast">
            <div class="d-flex">
                <div class="toast-body">
                    test
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div> --}}
</div>

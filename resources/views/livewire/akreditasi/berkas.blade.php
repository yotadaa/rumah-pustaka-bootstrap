<div class="border card">
    <div class="card-body">
        <div class="mb-0 d-flex justify-content-between align-items-center">
            <label class="gap-2 mb-2 text-2xl font-bold gk-text-base-black d-flex align-items-center">
                <img src="{{ asset('heroicons/Icon/Outline/document-texthero.svg') }}" class="me-2" />
                Daftar Berkas Penilaian {{ $type }}
            </label>
            @if (auth()->user()->pangkat == 0)
                <button class="gap-1 btn btn-primary d-flex align-items-center" wire:click="toggleFormBerkas">
                    <i class="bi {{ $showFormBerkas ? 'bi-dash' : 'bi-plus' }} fs-5"></i>
                    <span>{{ $showFormBerkas ? 'Tutup Form' : 'Tambah Berkas' }}</span>
                </button>
            @endif
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mx-4 mt-2 mb-0 text-center alert alert-success"
            style="{{ session('message') ? 'display: block;' : 'display: none;' }}">
            <button type="button" class="btn-close float-end" aria-label="Close"
                onclick="this.parentElement.style.display='none';"></button>
            {{ session('message') }}
        </div>
    @endif

    <div class="p-4 border-2 ">
    </div>

</div>

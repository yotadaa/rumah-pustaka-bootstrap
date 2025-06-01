<div>

    <x-modal id="subAspek">
        @switch ($modal)
            @case('tambah-sub-aspek')
                tambah-sub
            @break

            @case('delete-sub-aspek')
                delete-sub
            @break

            @case('edit-sub-aspek')
                edit-sub
            @break

            @case('tambah-indikator')
                tambah-indikator
            @break

            @case('delete-indikator')
                delete-indikator
            @break

            @case('edit-indikator')
                edit-indikator
            @break

            @default
                default
        @endswitch

    </x-modal>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-2" style="flex-wrap: wrap; overflow-x: auto;">
            <li class="breadcrumb-item">
                <a href="#">Akreditasi</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.akreditasi.daftar') }}">Berkas
                    {{ \App\Models\Berkas::findOrFail($berkas_id)->name }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.akreditasi.komponen', ['id' => $berkas_id, 'role_id' => -1]) }}">Komponen
                    {{ \App\Models\Komponen::findOrFail($komponen_id)->name }}</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a
                    href="{{ route('admin.akreditasi.aspek', ['berkas_id' => $berkas_id, 'komponen_id' => $komponen_id]) }}">Aspek
                    {{ \App\Models\Aspek::findOrFail($aspek_id)->name }}</a>
            </li>
        </ol>
    </nav>

    <div class="border card">
        <div class="card-body">
            <div class="mb-0 d-flex justify-content-between align-items-center">
                <div><a href="{{ route('admin.akreditasi.aspek', ['berkas_id' => $berkas_id, 'komponen_id' => $komponen_id]) }}"
                        class="btn btn-primary d-flex align-items-center"><i class="px-2 fas fa-chevron-left"></i><span
                            class="d-none d-md-block">Kembali</span></a></div>
                <div class="mb-2 text-2xl gk-text-base-black d-flex align-items-center" style="flex-direction: column">
                    <div class="font-bold">
                        <div class="dropdown">

                            <div class="text-center" style="cursor: pointer;" aria-expanded="false">Aspek
                                {{ $aspek->name }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gap-2 d-flex">
                    {{-- <button class="gap-1 btn btn-primary d-flex align-items-center" wire:click="changeDisplay"
                        style="padding: 10px 12px;"><i
                            class="@if ($display == 2) fas fa-th  @else fas fa-list @endif "></i></button> --}}
                </div>

                <script></script>
            </div>

        </div>
        <div class="px-4 overflow-auto py-2 d-flex gap-2 flex-column border-bottom border-2">
            <div class="fs-5 fw-bold text-dark">Terdapat {{ count($sub_aspeks) }} Sub Aspek</div>
        </div>
        <div class="p-4 overflow-auto border-2 d-flex gap-2 flex-column">
            <button class="gap-1 btn btn-primary w-fit" wire:click='toggleModal("tambah-sub-aspek")'>
                <i class="fa fa-circle-plus"></i>
                <span>Tambah Sub-Aspek</span>
            </button>
            @foreach ($sub_aspeks as $sub)
                <div style=""
                    class="bg-dark rounded fw-bold text-light w-100 p-0 m-0 d-flex align-items-center justify-content-between px-1">
                    <div class="d-flex align-items-center ">
                        <div class="cursor-pointer">
                            <i class="px-1 fas fa-chevron-up @if ($loop->index == 0) text-dark @endif"></i>
                        </div>
                        <div class="cursor-pointer">
                            <i class="px-1 fas fa-chevron-down @if ($loop->index == count($sub_aspeks) - 1) text-dark @endif "></i>
                        </div>
                        <div class="p-2"> {{ $aspek->no }}.{{ $sub->no }}. {{ $sub->name }}</div>
                    </div>
                    <div class="" style="flex-wrap: nowrap;white-space: nowrap;">

                        @if (auth()->user()->pangkat == 0)
                            <a wire:click='toggleModal("tambah-indikator")' class="btn btn-sm btn-light" wire:ignore>
                                <i class="fas fa-plus"></i> <span class="d-md-inline d-none">Tambah Indikator</span>
                            </a>
                        @endif
                        @if (auth()->user()->pangkat == 0)
                            <a class="btn btn-sm btn-secondary" wire:click='toggleModal("edit-sub-aspek")'>
                                <i class="fas fa-pen"></i>
                            </a>
                        @endif
                        @if (auth()->user()->pangkat == 0)
                            <button class="btn btn-sm btn-danger" wire:click='toggleModal("delete-sub-aspek")'>
                                <i class="fas fa-trash"></i>
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        window.addEventListener('showModal', () => {
            console.log("success {{ $modal }}");
            const modal = new bootstrap.Modal(document.getElementById('subAspek'));
            modal.show();
        });
    </script>


</div>

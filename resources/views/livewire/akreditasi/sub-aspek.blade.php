<div>
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
                        <div class="cursor-pointer"
                            @if ($loop->index != 0) wire:click="changeDirection('{{ $sub->id }}', 1)" @endif>
                            <i class="px-1 fas fa-chevron-up @if ($loop->index == 0) text-dark @endif"></i>
                        </div>
                        <div class="cursor-pointer"
                            @if ($loop->index != count($sub_aspeks) - 1) wire:click="changeDirection('{{ $sub->id }}', -1)" @endif>
                            <i class="px-1 fas fa-chevron-down @if ($loop->index == count($sub_aspeks) - 1) text-dark @endif "></i>
                        </div>
                        <div class="p-2"> {{ $aspek->no }}.{{ $sub->no }}. {{ $sub->name }}</div>
                    </div>
                    <div class="" style="flex-wrap: nowrap;white-space: nowrap;">

                        @if (auth()->user()->pangkat == 0)
                            <a wire:click='toggleModal("tambah-indikator", false, "tambah-indikator", "{{ $sub->id }}")'
                                class="btn btn-sm btn-light" wire:ignore>
                                <i class="fas fa-plus"></i> <span class="d-md-inline d-none">Tambah Indikator</span>
                            </a>
                        @endif
                        @if (auth()->user()->pangkat == 0)
                            <a class="btn btn-sm btn-secondary"
                                wire:click='toggleModal("tambah-sub-aspek", false, "edit","{{ $sub->id }}")'>
                                <i class="fas fa-pen"></i>
                            </a>
                        @endif
                        @if (auth()->user()->pangkat == 0)
                            <button class="btn btn-sm btn-danger"
                                wire:click='toggleModal("delete-sub-aspek", false, "del","{{ $sub->id }}")'>
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


    <x-my-modal modal="{{ $modal }}">
        <section key="modal-{{ $modal }}" style="transition: opacity 0.3s ease, visibility 0.3s ease;">
            @switch ($modal)
                @case('tambah-sub-aspek')
                    <form wire:submit.prevent="subAspekForm">
                        <div class="row g-3">

                            <!-- Dropdown -->
                            <!-- Input Text -->
                            <div class="col-md">
                                <label for="inputText" class="form-label">Nama Sub-Aspek</label>
                                <input type="text" class="form-control  @error('formName') is-invalid  @enderror"
                                    id="inputText" placeholder="Nama Sub-Aspek" name="sub_aspek_name"
                                    wire:model="sub_aspek_name">
                                @error('sub_aspek_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-3 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary w-full mb-2 shadow border">Simpan Perubahan</button>
                        </div>

                        <!-- Success Message -->
                        @if (session()->has('message'))
                            <div class="mt-3 alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                    </form>
                @break

                @case('delete-sub-aspek')
                    <header class="fs-4 fw-bold text-dark">Konfirmasi Penghapusan</header>
                    <section><span class="fw-bold text-dark">Peringatan!</span> dengan menghapus sub-aspek, maka seluruh
                        indikator di dalamnya akan ikut terhapus!</section>
                    <section class="mt-2">
                        Konfirmasi penghapusan dengan mengetik "<span
                            class="fw-bold text-dark">{{ isset($delete_sub->name) ? $delete_sub->name : 'Name Sub-Aspek' }}</span>"
                        pada
                        isian
                        di bawah!
                    </section>
                    <section class="py-2">
                        <section class="form-group">
                            <input class="form-control border-dark"
                                placeholder="{{ isset($delete_sub->name) ? $delete_sub->name : 'Name Sub-Aspek' }}"
                                wire:model="confirm_delete_sub" />
                        </section>
                    </section>
                    <section class="form-group my-2">
                        <button class="w-full btn btn-primary" wire:click="delete_sub_aspek()">Konfirmasi
                            Menghapus</button>
                    </section>
                @break

                @case('tambah-indikator')
                    <form class="my-2" wire:submit.prevent="submit_indikator">
                        <div class="form-group">
                            <label class="form-label">Konten Indikator</label>
                            <textarea name="indikator_konten" wire:model='indikator_konten' placeholder="Masukkan Kontent Indikator"
                                class="form-control border-dark"></textarea>
                        </div>

                        <button class="btn btn-info w-full my-2" wire:click='toggleMultiSoal()'>Multi-Soal</button>

                        <div @if ($indikator_multi) style="opacity: 0.3; pointer-events: none;" @endif>
                            <div class="form-group mt-2">
                                <label class="form-label">Pilihan</label>
                            </div>
                            <div class="form-group py-1 d-flex align-items-center">
                                <label class="form-label px-2">a. </label>
                                <input placeholder="Pilihan a" name="indikator_a" wire:model="indikator_a"
                                    class="form-control " />
                            </div>
                            <div class="form-group py-1 d-flex align-items-center">
                                <label class="form-label px-2">b. </label>
                                <input placeholder="Pilihan b" name="indikator_b" wire:model="indikator_b"
                                    class="form-control " />
                            </div>
                            <div class="form-group py-1 d-flex align-items-center">
                                <label class="form-label px-2">c. </label>
                                <input placeholder="Pilihan c" name="indikator_c" wire:model="indikator_c"
                                    class="form-control " />
                            </div>
                            <div class="form-group py-1 d-flex align-items-center">
                                <label class="form-label px-2">e. </label>
                                <input placeholder="Pilihan d" name="indikator_d" wire:model="indikator_d"
                                    class="form-control " />
                            </div>
                            <div class="form-group py-1 d-flex align-items-center">
                                <label class="form-label px-2">e. </label>
                                <input placeholder="Pilihan e" name="indikator_e" wire:model="indikator_e"
                                    class="form-control " />
                            </div>
                        </div>
                        <div class="form-group py-1 d-flex align-items-center">
                            <button type="submit" class="btn shadow btn-primary w-100">
                                Submit
                            </button>
                        </div>

                    </form>
                @break

                @case('delete-indikator')
                    delete-indikator
                @break

                @case('edit-indikator')
                    edit-indikator
                @break

                @default
                    default {{ $modal }}
            @endswitch
        </section>
        <footer>
            <button class="btn shadow btn-danger w-100" wire:click='toggleModal("none", true)'>
                Tutup Form
            </button>
        </footer>
    </x-my-modal>
</div>

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
        <div class="p-4 overflow-auto border-2 d-flex gap-0 flex-column">

            @if (auth()->user()->pangkat == 0)
                <div class="row px-3 gap-2">
                    <button class="gap-1 col-2 btn btn-primary " wire:click='toggleModal("tambah-sub-aspek")'>
                        <i class="fa fa-circle-plus"></i>
                        <span>Tambah Sub-Aspek</span>
                    </button>
                    <button wire:click='toggleModal("tambah-indikator", false, "tambah-indikator", null)'
                        class="btn col-2 btn-sm btn-light border-dark fs-3" wire:ignore>
                        <i class="fas fa-plus"></i> <span class="d-md-inline d-none">Tambah Indikator</span>
                    </button>
                </div>
            @endif

            @foreach ($sub_aspeks as $sub)
                @php $sub_loop = $loop; @endphp
                <div style=""
                    class="my-1 bg-dark overflow-auto rounded fw-bold text-light w-100 p-0 m-0 d-flex align-items-center justify-content-between px-1">
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
                @php
                    $ind_loop = 0;
                @endphp

                @foreach ($indikator as $ind)
                    @if ($ind->sub_aspek_id == $sub->id)
                        @php
                            $ind_loop++;
                        @endphp
                        @if (!$ind->multiple && $ind->sub_id == null)
                            <div class="gap-0 container @if ($ind->sub_id != null) border-start border-end border-dark rounded-0 @else my-1 border border-dark rounded @endif px-0 m-0 p-0"
                                style=";">


                                <div class="row px-2 ">
                                    {{-- {{ count(\App\Models\Indikator::where('sub_id', $ind->sub_id)->get()) }}    --}}
                                    <!-- Kolom 1 (1/4) -->

                                    <!-- Kolom 2 (2/4 atau 1/2) -->
                                    <div class="col-12 col-md-6  text-dark">
                                        {!! $ind->content !!}
                                    </div>

                                    <!-- Kolom 3 (1/4) -->
                                    <div class="col-12 col-md-3 d-flex flex-column gap-1 py-2">
                                        @foreach (\App\Models\OpsiIndikator::where('indikator_id', $ind->id)->get() as $opsi)
                                            <label
                                                class="p-2 rounded-2 shadow btn btn-light text-start position-relative d-flex align-items-center gap-2">
                                                <input type="radio" name="jawaban_opsi_{{ $ind->id }}"
                                                    value="{{ $opsi->id }}"
                                                    style="outline: 0; transition: all ease-in-out 0.2s;"
                                                    class="form-check-input m-0 border-1 border-primary outline-0" />
                                                <span>{{ $opsi->konten }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    <div class="col-12 col-md-3 d-flex flex-column gap-1 align-items-center py-2">
                                        @if (auth()->user()->pangkat == 0)
                                            <div class=" d-flex gap-2 justify-content-center h-fit">
                                                <button
                                                    class="btn btn-dark shadow col-4 d-flex h-fit justify-content-center align-items-center btn-primary">
                                                    <i class="fas fa-chevron-up"></i>
                                                </button>
                                                <div
                                                    class="btn btn-light border border-dark py-1 shadow col-4 d-flex h-fit justify-content-center align-items-center btn-primary">
                                                    {{ $ind->no + $sub->no }}
                                                </div>
                                                <button
                                                    class="btn btn-dark col-4 d-flex h-fit justify-content-center align-items-center btn-primary">
                                                    <i class="fas fa-chevron-down"></i>
                                                </button>
                                            </div>
                                        @endif
                                        {{ $ind->no }} + {{ $sub->no }}
                                        {{-- @if (auth()->user()->pangkat == 0 && $ind->sub_id == null)
                                            <button class="btn btn d-flex align-items-center w-fit btn-primary">
                                                <i class="fas fa-plus"></i> Tambah Soal &nbsp;&nbsp;&nbsp;&nbsp;
                                            </button>
                                        @endif --}}
                                        @if (auth()->user()->pangkat == 0)
                                            <button class="btn btn d-flex align-items-center  w-fit btn-info">
                                                <i class="fas fa-pen"></i> Edit indikator &nbsp;&nbsp;&nbsp;&nbsp;
                                            </button>
                                        @endif
                                        @if (auth()->user()->pangkat == 0)
                                            <button class="btn btn d-flex align-items-center  w-fit btn-danger">
                                                <i class="fas fa-trash"></i> Hapus indikator
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @elseif ($ind->multiple)
                            @php
                                //$ind_loop--;
                            @endphp
                            <div class="container border border-dark rounded rounded-top-3  px-0 m-0 p-0 "
                                style=";">
                                @if ($ind->multiple)
                                    <header class="bg-dark w-100 rounded-top-2 py-1 text-light px-5 mx-0 d-flex">
                                        {{ $ind->no + $sub_loop->index + $sub->no }}. {!! $ind->content !!}
                                    </header>

                                    <div class=" d-flex flex-row gap-1  p-2 align-items-center ">
                                        @if (auth()->user()->pangkat == 0)
                                            <div class=" d-flex gap-2 justify-content-center h-fit px-2">
                                                <button
                                                    class="btn btn-dark shadow col-4 d-flex h-fit justify-content-center align-items-center btn-primary">
                                                    <i class="fas fa-chevron-up"></i>
                                                </button>
                                                <div
                                                    class="btn btn-light border border-dark py-1 shadow col-4 d-flex h-fit justify-content-center align-items-center btn-primary">
                                                    {{ $ind->no + $sub->no }}
                                                </div>
                                                <button
                                                    class="btn btn-dark col-4 d-flex h-fit justify-content-center align-items-center btn-primary">
                                                    <i class="fas fa-chevron-down"></i>
                                                </button>
                                            </div>
                                            <button class="btn btn w-fit btn-primary"
                                                wire:click='toggleModal("tambah-indikator", false, "tambah-indikator", "{{ $sub->id }}", "{{ $ind->id }}")'>
                                                <i class="fas fa-plus"></i> Tambah Soal &nbsp;&nbsp;&nbsp;&nbsp;
                                            </button>
                                        @endif
                                        @if (auth()->user()->pangkat == 0)
                                            <button class="btn btn w-fit btn-info">
                                                <i class="fas fa-pen"></i> Edit indikator &nbsp;&nbsp;&nbsp;&nbsp;
                                            </button>
                                        @endif
                                        @if (auth()->user()->pangkat == 0)
                                            <button class="btn btn w-fit btn-danger">
                                                <i class="fas fa-trash"></i> Hapus indikator
                                            </button>
                                        @endif
                                    </div>
                                @endif

                                @foreach (\App\Models\Indikator::where('sub_id', $ind->id)->get() as $sub_ind)
                                    <div class="row px-2">
                                        <!-- Kolom 1 (1/4) -->
                                        <div class="col-12 col-md-6 text-dark shadow p-3">
                                            {!! $sub_ind->content !!}
                                        </div>

                                        <!-- Kolom 3 (1/4) -->
                                        <div class="col-12 col-md-3 d-flex flex-column gap-1 py-2">
                                            @foreach (\App\Models\OpsiIndikator::where('indikator_id', $sub_ind->id)->get() as $opsi)
                                                <label
                                                    class="p-2 rounded-2 shadow btn btn-light text-start position-relative d-flex align-items-center gap-2">
                                                    <input type="radio" name="jawaban_opsi_{{ $ind->id }}"
                                                        value="{{ $opsi->id }}"
                                                        style="outline: 0; transition: all ease-in-out 0.2s;"
                                                        class="form-check-input m-0 border-1 border-primary outline-0" />
                                                    <span>{{ $opsi->konten }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                        <div
                                            class="col-12 col-md-3 d-flex flex-column gap-1  py-2 align-items-center ">
                                            @if (auth()->user()->pangkat == 0)
                                                <div class=" d-flex gap-2 justify-content-center h-fit">
                                                    <button
                                                        class="btn btn-dark shadow col-4 d-flex h-fit justify-content-center align-items-center btn-primary">
                                                        <i class="fas fa-chevron-up"></i>
                                                    </button>
                                                    <div
                                                        class="btn btn-light border border-dark py-1 shadow col-4 d-flex h-fit justify-content-center align-items-center btn-primary">
                                                        0
                                                    </div>
                                                    <button
                                                        class="btn btn-dark col-4 d-flex h-fit justify-content-center align-items-center btn-primary">
                                                        <i class="fas fa-chevron-down"></i>
                                                    </button>
                                                </div>
                                            @endif
                                            @if (auth()->user()->pangkat == 0)
                                                <button class="btn btn w-fit btn-info">
                                                    <i class="fas fa-pen"></i> Edit indikator &nbsp;&nbsp;&nbsp;&nbsp;
                                                </button>
                                            @endif
                                            @if (auth()->user()->pangkat == 0)
                                                <button class="btn btn w-fit btn-danger">
                                                    <i class="fas fa-trash"></i> Hapus indikator
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endif
                @endforeach
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
        <section key="modal-{{ $modal }}" style="transition: opacity 0.3s ease, visibility 0.3s ease; "
            class="overflow-y-auto">
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
                            <button type="submit" class="btn btn-primary w-full mb-2 shadow border">Simpan
                                Perubahan</button>
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
                    <section><span class="fw-bold text-dark">Peringatan!</span> dengan menghapus sub-aspek,
                        maka seluruh
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
                    <form class="my-2 " wire:submit.prevent="submit_indikator">
                        <div class="overflow-y-auto" style="max-height: 500px;">
                            <div class="form-group">
                                <label class="form-label">Konten Indikator</label>

                                {{-- 🔑 Bind this to Livewire --}}
                                <div x-data="{ content: '' }" wire:ignore>
                                    <input type="hidden" id="indikator_konten_input" wire:model.defer="indikator_konten">
                                    <div>
                                        <trix-editor class="overflow-y-auto" style="max-height: 300px;"
                                            input="indikator_konten_input"></trix-editor>
                                    </div>
                                    <script>
                                        const input_trix = document.getElementById("indikator_konten_input");
                                        input_trix.addEventListener("input", function(event) {
                                            console.log("test");
                                        });
                                    </script>
                                </div>
                            </div>

                            <a href="#" class="btn btn-info w-full my-2" wire:click='toggleMultiSoal()'>Multi-Soal</a>

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
    <script>
        document.addEventListener('trix-initialize', function() {
            const editor = document.querySelector('trix-editor[input="indikator_konten_input"]');
            const hiddenInput = document.getElementById('indikator_konten_input');

            editor.addEventListener('trix-change', function() {
                // Trix already updates hidden input value automatically
                // Just trigger Livewire to notice the change
                hiddenInput.dispatchEvent(new Event('input', {
                    bubbles: true
                }));
            });
        });
    </script>
</div>

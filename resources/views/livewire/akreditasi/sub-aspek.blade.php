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
                </div>

                <script></script>
            </div>

        </div>
        <div class="px-4 overflow-auto py-2 d-flex gap-2 flex-column border-bottom border-2">
            <div class="fs-5 fw-bold text-dark">Terdapat {{ count($sub_aspeks) }} Sub Aspek</div>
        </div>
        <div class="p-4 overflow-auto border-2 d-flex gap-0 flex-column row">
            <div class="my-3 rounded border border-dark col-12 col-md-6">
                <div class="row px-3">
                    <div class="col-3 py-1  text-dark fs-4  ">Total
                        Skor</div>
                    <div class="col-5 border-start-0  text-dark fs-4  py-1 ">
                        {{ round($total_skor, 2) }} Poin / 90 Poin ({{ round(($total_skor / 90) * 100, 2) }}%)</div>
                </div>
                <div class="row px-3 ">
                    <div class="col-3 py-1  text-dark fs-4 ">Total Skor</div>
                    <div class="col-5 border-start-0  text-dark fs-4  py-1">
                        {{ round($total_skor, 2) }} Poin / 90 Poin ({{ round(($total_skor / 90) * 100, 2) }}%)</div>
                </div>
            </div>

            @if (auth()->user()->pangkat == 0)
                <div class="row px-3 gap-2">
                    <button class="gap-2 col-12 col-md-2 btn btn-primary " wire:click='toggleModal("tambah-sub-aspek")'>
                        <i class="fa fa-plus"></i>
                        <span>Tambah Sub-Aspek</span>
                    </button>
                    <button wire:click='toggleModal("tambah-indikator", false, "tambah-indikator", null)'
                        class="btn col-12 col-md-2 btn-sm btn-light border-dark fs-3" wire:ignore>
                        <i class="fas fa-plus"></i> <span class="d-md-inline d-none">Tambah Indikator</span>
                    </button>
                </div>
            @endif






            <div style=""
                class="my-1 bg-light border-dark border overflow-auto rounded fw-bold text-dark w-100 p-0 m-0 d-flex align-items-center justify-content-between ">
                <div class="d-flex align-items-center ">
                    <div class="btn btn-dark p-1 px-2 rounded-0">
                        <i class="fa fa-circle-info"></i>
                    </div>
                    <div class="px-2">Indikator tanpa sub-aspek</div>
                </div>
                <div class="btn btn-dark rounded-0 p-1 px-2">
                    <i class="fa fa-chevron-down"></i>
                </div>
            </div>


            @foreach ($indikator as $ind)
                @if ($ind->sub_aspek_id == null)
                    @include('livewire.akreditasi.sub-aspek.no-sub-aspek', [
                        'ind' => $ind,
                        'aspek_id' => $aspek_id,
                    ])
                @endif
            @endforeach

            @foreach ($sub_aspeks as $sub)
                @php $sub_loop = $loop; @endphp

                <div style=""
                    class="my-1 bg-light border-dark border overflow-auto rounded fw-bold text-dark w-100 p-0 m-0 d-flex align-items-center justify-content-between ">
                    <div class="d-flex align-items-center gap-0 p-0 ">
                        <div class="cursor-pointer btn btn-sm btn-dark rounded-0 p-1"
                            @if ($loop->index != 0) wire:click="changeDirection('{{ $sub->id }}', 1)" @endif>
                            <i class="px-2 fas fa-chevron-up @if ($loop->index == 0) text-dark @endif"></i>
                        </div>
                        <div class="cursor-pointer btn btn-sm btn-dark rounded-0 p-1 "
                            @if ($loop->index != count($sub_aspeks) - 1) wire:click="changeDirection('{{ $sub->id }}', -1)" @endif>
                            <i class="px-1 fas fa-chevron-down @if ($loop->index == count($sub_aspeks) - 1) text-dark @endif "></i>
                        </div>
                        <div class="px-2"> {{ $aspek->no }}.{{ $sub->no }}. {{ $sub->name }}</div>
                    </div>
                    <div class="d-flex gap-1" style="flex-wrap: nowrap;white-space: nowrap;">

                        @if (auth()->user()->pangkat == 0)
                            <button
                                wire:click='toggleModal("tambah-indikator", false, "tambah-indikator", "{{ $sub->id }}")'
                                class="btn btn-sm btn-dark border-light" wire:ignore>
                                <i class="fas fa-plus"></i> <span class="d-md-inline d-none">Tambah Indikator</span>
                            </button>
                        @endif
                        @if (auth()->user()->pangkat == 0)
                            <button class="btn btn-sm btn-secondary  "
                                wire:click='toggleModal("tambah-sub-aspek", false, "edit","{{ $sub->id }}")'>
                                <i class="fas fa-pen"></i>
                            </button>
                        @endif
                        @if (auth()->user()->pangkat == 0)
                            <button class="btn btn-sm btn-danger "
                                wire:click='toggleModal("delete-sub-aspek", false, "del","{{ $sub->id }}")'>
                                <i class="fas fa-trash"></i>
                            </button>
                        @endif
                        <div class="btn btn-sm btn-dark rounded-0 p-1 px-2">
                            <i class="fa fa-chevron-down"></i>
                        </div>
                    </div>
                </div>
                @php
                    $ind_loop = 0;
                @endphp
                @foreach ($indikator as $ind)
                    @if ($ind->sub_aspek_id == $sub->id)
                        @include('livewire.akreditasi.sub-aspek.no-sub-aspek', [
                            'ind' => $ind,
                            'aspek_id' => $aspek_id,
                        ])
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
        @if ($is_processing)
            <div class="position-absolute rounded-2"
                style="width: 100%; height: 100%; top: 0; left: 0;background-color:rgba(0,0,0,.5)">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div class="spinner-border text-light" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        @endif
        <section key="modal-{{ $modal }}" style="transition: all 0.3s ease, visibility 0.3s ease; "
            class="overflow-y-auto">
            @switch ($modal)
                @case('tambah-sub-aspek')
                    <form style="transition: opacity 0.3s ease, visibility 0.3s ease;" wire:submit.prevent="subAspekForm">
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
                    <form
                        style="transition: all 0.3s ease, visibility 0.3s ease;opacity: {{ $modal != null ? '1' : '0' }};visibility: {{ $modal != null ? 'visible' : 'hidden' }};"
                        class="my-2 " wire:submit.prevent="submit_indikator">
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

                            @if ($this->ind_id == null)
                                <a href="#" class="btn btn-info w-full my-2"
                                    wire:click='toggleMultiSoal()'>Multi-Soal</a>
                            @endif

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
                    <header class="fs-4 fw-bold text-dark">Konfirmasi Penghapusan Indikator</header>
                    <section><span class="fw-bold text-dark">Peringatan!</span> dengan menghapus indikator,
                        maka seluruh
                        opsi jawaban di dalamnya akan ikut terhapus!</section>
                    <section class="mt-2">
                        Apakah Anda yakin ingin menghapus indikator ini?
                    </section>
                    <section class="form-group my-2 d-flex gap-2 ">
                        <button class="btn col-12 shadow btn-primary " wire:click="delete_indikator()">Konfirmasi
                            Menghapus</button>
                    </section>
                @break

                @case('edit-indikator')
                    <div class="col"style="max-height: 80vh; oveflow-y: auto;">
                        {{-- Dropdown Aspek --}}
                        <div class="dropdown mb-3 col">
                            <button class="btn btn-outline-dark dropdown-toggle col-12" type="button"
                                data-bs-toggle="dropdown">
                                {{ $label_edit_aspek ?? 'Pilih Aspek' }}
                            </button>
                            <ul class="dropdown-menu col-12 border border-dark shadow">
                                @foreach (\App\Models\Aspek::where('komponen_id', $komponen_id)->get() as $aspek)
                                    <li class="col-12 border-bottom border-dark ">
                                        <button class="dropdown-item col-12 btn btn-dark"
                                            wire:click="chooseAspekEdit('{{ $aspek->id }}')"
                                            style="white-space: normal;overflow-x: hidden; text-overflow: ellipsis;">
                                            {{-- Display the aspect number --}}
                                            {{ $aspek->no }}.
                                            {{-- Display the aspect name --}}
                                            {{ $aspek->name }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="dropdown mb-3 col">
                            <button @if ($edit_aspek_id == null) @disabled('true') @endif
                                class="btn btn-outline-dark dropdown-toggle col-12" type="button" data-bs-toggle="dropdown"
                                style="overflow-x: hidden; text-overflow: ellipsis;">
                                {{ $label_edit_sub_aspek ?? 'Pilih Sub-Aspek' }}
                            </button>
                            <ul class="dropdown-menu col-12 border border-dark shadow">
                                <li class="col-12 border-bottom border-dark ">
                                    <button class="dropdown-item col-12 btn btn-dark" wire:click="chooseSubAspekEdit(null)">
                                        {{-- Display the aspect number and sub-aspect number --}}
                                        Tanpa kategori
                                    </button>
                                </li>
                                @foreach (\App\Models\SubAspek::where('aspek_id', $aspek_id)->get()->sortBy('no') as $sub)
                                    <li class="col-12 border-bottom border-dark @if ($sub->id == $edit_sub_aspek_id) text-dark bg-dark @endif"
                                        style="white-space: normal;overflow-x: hidden; text-overflow: ellipsis;">
                                        <button
                                            class="dropdown-item @if ($sub->id == $edit_sub_aspek_id) text-light bg-dark @endif"
                                            wire:click="chooseSubAspekEdit('{{ $sub->id }}')"
                                            style="overflow-x: hidden; text-overflow: ellipsis;">
                                            {{ \App\Models\Aspek::where('id', $aspek_id)->first()->no }}.{{ $sub->no }}.
                                            {{ $sub->name }}
                                        </button>
                                    </li>
                                @endforeach

                            </ul>
                        </div>

                        <div class="dropdown mb-3">
                            <button class="btn btn-outline-dark col-12 d-flex align-items-center gap-2 justify-content-center"
                                type="button" data-bs-toggle="dropdown">
                                {!! $label_edit_indikator ?? 'Pilih Indikator' !!} <i class="fas fa-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu col-12 border border-dark shadow"
                                style="max-height: 300px; overflow-y: auto;">
                                <li class="col-12 border-bottom border-dark">
                                    <a class="dropdown-item  col-12 btn btn-dark flex-wrap" style="white-space: normal;"
                                        wire:click="chooseIndikatorEdit(null)">
                                        Tanpa Sub-Indikator

                                    </a>
                                </li>
                                @foreach (\App\Models\Indikator::where(['aspek_id' => $aspek_id, 'multiple' => true])->get() as $indikator)
                                    <li class="col-12 border-bottom border-dark">
                                        <a class="dropdown-item  col-12 btn btn-dark flex-wrap" style="white-space: normal;"
                                            wire:click="chooseIndikatorEdit('{{ $indikator->id }}')">
                                            {!! \Illuminate\Support\Str::words($indikator->content, 5, '...') !!}

                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="overflow-y-auto" style="max-height: 300px;">
                            <div class="form-group">
                                <label class="form-label">Konten Indikator</label>

                                <div>
                                    <input id="indikator_konten_input" type="hidden"
                                        wire:model.defer="edit_indikator_content" value="{{ $edit_indikator_content }}">
                                    <trix-editor input="indikator_konten_input" class="overflow-y-auto"
                                        style="max-height: 300px;" placeholder="Konten Indikator"></trix-editor>
                                </div>
                            </div>
                            {{-- @if (\App\Models\Indikator::findOrFail($ind_id)->multiple) --}}
                            <div class="form-group my-2">
                                <div @if (\App\Models\Indikator::findOrFail($ind_id)->multiple) style="opacity: 0.3; pointer-events: none;" @endif>
                                    <div class="form-group ">
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
                            {{-- @endif --}}

                        </div>
                        <div class="col my-2">
                            <button class="btn shadow btn-primary col-12" wire:click='confirm_indikator_edit()'>
                                Konfirmasi Perubahan
                            </button>
                        </div>
                    </div>
                @break

                @default
                    default {{ $modal }}
            @endswitch
        </section>
        <footer>
            <button class="btn shadow btn-danger w-100"
                wire:click='toggleModal("none",
                            true)'>
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
    <script>
        window.addEventListener('refresh-page', () => {
            window.location.reload();
        });
    </script>

</div>

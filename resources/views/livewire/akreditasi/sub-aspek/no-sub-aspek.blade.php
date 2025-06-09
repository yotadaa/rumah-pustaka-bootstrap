<div wire:key="indikator-{{ $ind->id }}">
    @php
        $jumlah_indikator_terjawab = $indikator_option
            // 1. Filter koleksi OPSI berdasarkan aspek_id dari relasi indikator
            ->where('choosen', true)
            ->where('indikator.aspek_id', $aspek_id)

            // 2. Ambil hanya objek INDIKATOR dari setiap opsi yang lolos filter
            ->pluck('indikator')

            // 3. Buat koleksi INDIKATOR ini menjadi unik berdasarkan primary key 'id'-nya
            ->unique('id')
            ->filter(function ($i) {
                if ($i->sub_id == null) {
                    return true;
                } else {
                    try {
                        $parent = \App\Models\Indikator::findOrFail($i->sub_id);
                        return true;
                    } catch (\Exception $e) {
                        return false;
                    }
                }
            })
            ->pluck('id')
            ->toArray();
    @endphp
    @if ($ind->sub_id == null)
        @if (!$ind->multiple)
            <div class="gap-0 container @if ($ind->sub_id != null) border-start border-end border-dark rounded-0 @else my-1 border border-dark rounded @endif px-0 m-0 p-0"
                style=";">


                <div class="row px-2 ">
                    <div class="col-12 col-md-6 p-3 text-dark">
                        {!! $ind->content !!}
                    </div>
                    <div class="col-12 col-md-3 d-flex flex-column gap-1 py-2">
                        @foreach ($indikator_option->where('indikator_id', $ind->id) as $opsi)
                            <label
                                class="p-2 rounded-2 border-dark border-1 shadow btn btn-light text-start position-relative d-flex align-items-center gap-2">
                                <input type="radio" name="jawaban_opsi_{{ $ind->id }}" value="{{ $opsi->id }}"
                                    @if ($opsi->choosen) checked @endif
                                    style="outline: 0; transition: all ease-in-out 0.2s;"
                                    class="form-check-input m-0 border-1 border-primary outline-0"
                                    wire:click='setScore("{{ $opsi->id }}")' />
                                <span>{{ $opsi->konten }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="col-12 col-md-3 d-flex flex-column gap-1 justify-content-start align-items-center py-2">
                        @if (auth()->user()->pangkat == 0)
                            <div class=" d-flex gap-2 justify-content-center h-fit">
                                <button wire:click='move_indikator("{{ $ind->id }}", -1)'
                                    class="btn btn-dark shadow col-4 d-flex h-fit justify-content-center align-items-center btn-primary">
                                    <i class="fas fa-chevron-up"></i>
                                </button>
                                <div
                                    class="btn btn-light border border-dark py-1 shadow col-4 d-flex h-fit justify-content-center align-items-center btn-primary">
                                    {{ $ind->no }}
                                </div>
                                <button wire:click='move_indikator("{{ $ind->id }}", 1)'
                                    class="btn btn-dark col-4 d-flex h-fit justify-content-center align-items-center btn-primary">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </div>
                        @endif
                        @if (auth()->user()->pangkat == 0)
                            <div class="col-12">
                                <button class="col-12 mt-1 gap-2 btn d-flex align-items-center btn-info"
                                    wire:click='toggleModal("edit-indikator", false, "edit-indikator", null, "{{ $ind->id }}")'>
                                    <i class="fas fa-gear"></i> Edit indikator
                                </button>
                                <button class="col-12 mt-1 gap-2 btn d-flex align-items-center btn-danger"
                                    wire:click='toggleModal("delete-indikator", false, "delete-indikator", null, "{{ $ind->id }}")'>
                                    <i class="fas fa-trash"></i> Hapus indikator
                                </button>
                                @if (in_array($ind->id, $jumlah_indikator_terjawab))
                                    <button wire:click='clear_option("{{ $ind->id }}")'
                                        class="col-12 mt-1 gap-2 btn d-flex align-items-center btn-warning border border-dark text-dark">
                                        <i class="fas fa-trash"></i> Bersihkan jawaban
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="container border border-dark rounded rounded-top-3  px-0 m-0 p-0 my-3" style=";">
                <header class="bg-dark w-100 rounded-top-2 py-1 text-light px-5 mx-0 d-flex fw-bold fs-4">
                    {{ $ind->no }}.&nbsp;&nbsp;&nbsp;&nbsp; {!! $ind->content !!}
                </header>

                <div class=" d-flex flex-row gap-1  p-2 align-items-center col" style="overflow-y: auto;">
                    @if (auth()->user()->pangkat == 0)
                        <div class="d-flex gap-2 justify-content-center h-fit px-2 col-12 col-md-3">
                            <button wire:click='move_indikator("{{ $ind->id }}", -1)'
                                class="btn btn-dark shadow col-4 d-flex h-fit justify-content-center align-items-center btn-primary">
                                <i class="fas fa-chevron-up"></i>
                            </button>
                            <div
                                class="btn btn-light border border-dark py-1 shadow col-4 d-flex h-fit justify-content-center align-items-center btn-primary">
                                {{ $ind->no }}
                            </div>
                            <button wire:click='move_indikator("{{ $ind->id }}", 1)'
                                class="btn btn-dark col-4 d-flex h-fit justify-content-center align-items-center btn-primary">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        <div class="col-md-6 col-12">
                            <button class="btn btn w-fit btn-primary col-12 col-md-2"
                                wire:click='toggleModal("tambah-indikator", false, "sub-soal", null, "{{ $ind->id }}")'>
                                <i class="fas fa-plus"></i> Tambah Soal &nbsp;&nbsp;&nbsp;&nbsp;
                            </button>
                            <button class="btn btn w-fit btn-info"
                                wire:click='toggleModal("edit-indikator", false, "edit-indikator", null, "{{ $ind->id }}")'>
                                <i class="fas fa-pen"></i> Edit indikator &nbsp;&nbsp;&nbsp;&nbsp;
                            </button>
                            <button class="btn btn w-fit btn-danger"
                                wire:click='toggleModal("delete-indikator", false, "delete-indikator", null, "{{ $ind->id }}")'>
                                <i class="fas fa-trash"></i> Hapus indikator
                            </button>
                        </div>
                    @endif
                </div>

                @foreach (\App\Models\Indikator::where('sub_id', $ind->id)->get() as $sub_ind)
                    <div class="row px-2 border-top border-dark mx-2" wire:key="indikator-inner-{{ $ind->id }}">
                        <!-- Kolom 1 (1/4) -->
                        <div class="col-12 col-md-6 text-dark  p-3 ">
                            {!! $sub_ind->content !!}
                        </div>

                        <!-- Kolom 3 (1/4) -->
                        <div class="col-12 col-md-3 d-flex flex-column gap-1 py-2 ">
                            @foreach ($indikator_option->where('indikator_id', $sub_ind->id) as $opsi)
                                <label
                                    class="p-2 rounded-2 border-dark border-1 shadow btn btn-light text-start position-relative d-flex align-items-center gap-2">
                                    <input type="radio" name="jawaban_opsi_{{ $ind->id }}"
                                        value="{{ $opsi->id }}" @if ($opsi->choosen) checked @endif
                                        style="outline: 0; transition: all ease-in-out 0.2s;"
                                        class="form-check-input m-0 border-1 border-primary outline-0"
                                        wire:click='setScore("{{ $opsi->id }}")' />
                                    <span>{{ $opsi->konten }}</span>
                                </label>
                            @endforeach
                        </div>
                        <div class="col-12 col-md-3 d-flex flex-column gap-1 py-2 align-items-center ">
                            @if (auth()->user()->pangkat == 0)
                                <div class=" d-flex gap-2 justify-content-center h-fit">
                                    <button wire:click='move_indikator("{{ $sub_ind->id }}", -1)'
                                        class="btn btn-dark shadow col-4 d-flex h-fit justify-content-center align-items-center btn-primary">
                                        <i class="fas fa-chevron-up"></i>
                                    </button>
                                    <div
                                        class="btn btn-light border border-dark py-1 shadow col-4 d-flex h-fit justify-content-center align-items-center btn-primary">
                                        0
                                    </div>
                                    <button wire:click='move_indikator("{{ $sub_ind->id }}", 1)'
                                        class="btn btn-dark col-4 d-flex h-fit justify-content-center align-items-center btn-primary">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                            @endif
                            <div class="row gap-2">
                                @if (auth()->user()->pangkat == 0)
                                    <button class="btn btn col-12 btn-info"
                                        wire:click='toggleModal("edit-indikator", false, "edit-indikator", null, "{{ $sub_ind->id }}")'>
                                        <i class="fas fa-pen"></i> Edit indikator &nbsp;&nbsp;&nbsp;&nbsp;
                                    </button>
                                    <button class="btn btn col-12 btn-danger"
                                        wire:click='toggleModal("delete-indikator", false, "delete-indikator", null, "{{ $ind->id }}")'>
                                        <i class="fas fa-trash"></i> Hapus indikator
                                    </button>
                                    @if (in_array($sub_ind->id, $jumlah_indikator_terjawab))
                                        <button wire:click='clear_option("{{ $sub_ind->id }}")'
                                            class="btn col-12 btn-warning border border-dark text-dark">
                                            <i class="fas fa-trash"></i> Bersihkan jawaban
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif

</div>

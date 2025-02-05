<div class="border card">
    <div class="card-body">
        <div class="mb-0 d-flex justify-content-between align-items-center">
            <label class="gap-2 mb-2 text-2xl font-bold gk-text-base-black d-flex align-items-center">
                <img src="{{ asset('heroicons/Icon/Outline/document-texthero.svg') }}" class="me-2" />
                Daftar Berkas {{ $confirmingDeleteText }}
            </label>
            @if (auth()->user()->pangkat == 0)
                <button class="gap-1 btn btn-primary d-flex align-items-center" wire:click="toggleFormBerkas">
                    <i class="bi {{ $showFormBerkas ? 'bi-dash' : 'bi-plus' }} fs-5"></i>
                    <span>{{ $showFormBerkas ? 'Tutup Form' : 'Tambah Berkas' }}</span>
                </button>
            @endif
        </div>
    </div>

    <div class="border-2 border-top"
        style="overflow: hidden; max-height: {{ $showFormBerkas ? '1000px' : '0' }}; transition: all 0.3s ease;">
        <form wire:submit.prevent="submit">
            <div class="p-4">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="row align-items-end g-2">
                            <div class="col-md-8">
                                <label class="form-label">Judul Berkas</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Masukkan judul berkas" wire:model="name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    {{ $berkasId ? 'Simpan Perubahan' : 'Tambah Berkas' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
        @if ($berkas->count() > 0)
            <div class="gap-2 list-group">
                @foreach ($berkas as $item)
                    <div class="gap-2 p-2 border-bottom row justify-content-start">
                        <input value="{{ $item->name }}" readonly class="col-12 col-sm fw-medium form-control"
                            disabled style="width: 100%;"></input>
                        <div class="gap-3 overflow-auto d-flex col-12 col-sm align-items-center">
                            <!-- Display Timestamp -->
                            <div class="text-muted">{{ $item->created_at->format('d M Y H:i') }}
                            </div>
                            <!-- Edit Button -->
                            <div class="gap-2 d-flex">
                                @if (auth()->user()->pangkat == 0)
                                    <button style="padding: 10px 10px;"
                                        class="gap-2 fs-3 btn btn-sm btn-secondary d-flex align-items-center"
                                        wire:click="editnama('{{ $item->id }}')">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                @endif

                                <!-- Details Button -->
                                <a href="{{ route('admin.iso.divisi', ['id' => $item->id]) }}"
                                    style="padding: 10px 10px;"
                                    class="gap-2 fs-3 btn btn-sm btn-warning d-flex align-items-center">
                                    <i class="fas fa-info-circle"></i>
                                </a>

                                <button type="button" style="padding: 10px 10px;"
                                    class="gap-2 fs-3 btn btn-sm btn-dark d-flex align-items-center"
                                    wire:click="downloadZip(null, '{{ $item->id }}')" wire:loading.attr="disabled">
                                    <i class="fas fa-download" wire:loading.remove wire:target="downloadZip"></i>
                                    <i class="fas fa-spinner fa-spin" wire:loading wire:target="downloadZip"></i>
                                </button>


                                <!-- Delete Button -->
                                @if (auth()->user()->pangkat == 0)
                                    <button type="button" 10tyle="padding: 0 10px;"
                                        class="gap-2 fs-3 btn btn-sm btn-danger d-flex align-items-center"
                                        wire:click="confirmDelete('{{ $item->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-3 text-center text-muted">
                Belum ada berkas yang ditambahkan
            </div>
        @endif
    </div>
    @if ($confirmingDelete != null)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Penghapusan</h5>
                        <button type="button" class="btn btn-danger btn-sm" wire:click="cancelDelete">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Ketik judul berkas
                            "<strong>{{ $confirmingDelete != null
                                ? $confirmingDelete->name
                                : "Nama
                                                                                                                Berkas" }}</strong>"
                            untuk
                            mengonfirmasi penghapusan:</p>
                        <input type="text" class="form-control" wire:model="confirmingDeleteText">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="cancelDelete">Batal</button>
                        <button type="button" class="btn btn-danger" wire:click="delete">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif


</div>

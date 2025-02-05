<div>
    <div class="border card">
        <div class="pb-0 card-body">
            <div class="mb-0 d-flex justify-content-between align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.iso.daftar') }}">Iso</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a
                                href="{{ route('admin.iso.komponen', ['id' => $berkas->id, 'role_id' => $role_id]) }}">{{ $berkas->name }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $komponen->name }}
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="card-body">
                <div class="mb-0 d-flex justify-content-between align-items-center h-100">
                    <div><a href="{{ route('admin.iso.komponen', ['id' => $berkas->id, 'role_id' => $role_id]) }}"
                            class="btn btn-primary d-flex align-items-center"><i
                                class="px-2 fas fa-chevron-left"></i><span class="d-none d-md-block">Kembali</span></a>
                    </div>
                    <div class="mb-2 text-2xl gk-text-base-black d-flex align-items-center"
                        style="flex-direction: column">
                        <div class="font-bold">
                            <div class="dropdown">
                                <div style="cursor: pointer;" id="inputDropdown" data-bs-toggle="dropdown"
                                    aria-expanded="false">Divisi {{ App\Models\Role::find($role_id)->name }} <i
                                        class="fas fa-chevron-down"></i></div>
                                <ul style="max-height: 500px; overflow-y: auto; width: fit-content"
                                    class="dropdown-menu " aria-labelledby="divisiDropdown">
                                    <!-- Added position-absolute -->
                                    @foreach (App\Models\Role::all() as $role)
                                        <li>
                                            <a href="{{ route('admin.iso.komponen.kelola', ['berkasId' => $berkasId, 'komponenId' => $komponenId, 'role_id' => $role->id]) }}"
                                                class="dropdown-item">
                                                {{ $role->name }} ({{ $role->id }})
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="fs-4">
                            Komponen {{ $komponen->name }}
                        </div>
                    </div>
                    <div class="gap-2 d-flex">
                        <div class="gap-2 d-flex align-items-start h-100">
                            @if (auth()->user()->pangkat == 0)
                                <button class="gap-1 btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                                    data-bs-target="#uploadFileModal">
                                    <i class="fa fa-plus fs-5"></i>
                                    <span>Tambah File</span>
                                </button>
                            @endif
                        </div>
                    </div>

                    <script></script>
                </div>
            </div>
        </div>
        <div class="container p-5 border border-top">
            @foreach ($komponen->files($berkas->id)->where('role_id', $role_id)->get() as $f)
                <div class="px-2 mb-2 row">
                    <div class="flex-wrap form-control col" style="flex-wrap:wrap;">
                        {{ $f->filename }}
                    </div>
                    <div class="gap-2 pt-2 col d-flex pt-sm-0 justify-content-end justify-content-sm-start">
                        <!-- View PDF Modal Button -->
                        <button style="padding: 10px 10px;"
                            class="gap-2 fs-3 btn btn-sm btn-secondary d-flex align-items-center"
                            onclick="showPdfModal('{{ $f->path }}', '{{ $f->filename }}')">
                            <i class="fas fa-eye"></i>
                        </button>

                        <!-- Delete Button -->
                        <button type="button" style="padding: 10px 10px;"
                            class="gap-2 fs-3 btn btn-sm btn-danger d-flex align-items-center">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="uploadFileModal" tabindex="-1" aria-labelledby="uploadFileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadFileModalLabel">Upload File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- File Upload Form -->
                    <form wire:submit.prevent="uploadFile" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="fileInput" class="form-label">Choose File</label>
                            <input type="file" class="form-control" id="fileInput" wire:model="file"
                                wire:loading.attr="disabled">
                            @error('file')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div wire:loading>
                            <span class="text-primary">Uploading file, please wait...</span>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                wire:loading.attr="disabled" id="closeModal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove>Upload</span>
                                <span wire:loading>
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Uploading...
                                </span>
                            </button>

                        </div>

                        <!-- Loading Indicator -->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- PDF Preview Modal (Placed Outside Loop) -->
    <div class="py-0 my-0 justify-content-start align-items-center modal fade" id="pdfModal" tabindex="-1"
        aria-labelledby="pdfModalLabel" aria-hidden="true" style="height: 100%; padding:0;">
        <div class="my-0 modal-dialog justify-content-start align-items-start modal-lg"
            style="height: 95%; padding:2% 0;">
            <div class=" modal-content" style="height: 100%;">
                <div class=" modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">PDF Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="text-center modal-body h-100" style="height: 100%;">
                    <iframe id="pdfIframe" src="" width="100%" style="height: 100%"></iframe>
                </div>
                <div class="modal-footer">
                    <a id="openInNewTab" href="#" target="_blank" class="btn btn-primary">
                        Open in New Tab
                    </a>
                    <a id="downloadPdf" href="#" download class="btn btn-success">
                        Download PDF
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showPdfModal(fileUrl, fileName) {
            const url = '{{ url('/') }}/' + fileUrl;
            document.getElementById('pdfIframe').src = url;
            document.getElementById('openInNewTab').href = url;
            document.getElementById('downloadPdf').href = url;
            document.getElementById('downloadPdf').download = fileName;
            document.getElementById('pdfModalLabel').textContent = "Preview: " + fileName;

            var modal = new bootstrap.Modal(document.getElementById('pdfModal'));
            modal.show();
        }
    </script>

    <script>
        window.addEventListener('file-uploaded', event => {
            var closeButton = document.getElementById('closeModal');
            closeButton.click();
        });
    </script>

</div>

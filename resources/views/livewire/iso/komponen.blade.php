<div class="border card">

    <script>
        const selectedRoles = [];
    </script>

    <div class="card-body">
        <div class="mb-0 d-flex justify-content-between align-items-center">
            <div><a href="{{ route('admin.iso.divisi', ['id' => $berkas->id]) }}"
                    class="btn btn-primary d-flex align-items-center"><i class="px-2 fas fa-chevron-left"></i><span
                        class="d-none d-md-block">Kembali</span></a></div>
            <div class="mb-2 text-2xl gk-text-base-black d-flex align-items-center" style="flex-direction: column">
                <div class="font-bold">
                    <div class="dropdown">
                        <div style="cursor: pointer;" id="inputDropdown" data-bs-toggle="dropdown"
                            aria-expanded="false">Divisi {{ App\Models\Role::find($role_id)->name }} <i
                                class="fas fa-chevron-down"></i></div>
                        <ul style="max-height: 500px; overflow-y: auto; width: fit-content" class="dropdown-menu "
                            aria-labelledby="divisiDropdown">
                            <!-- Added position-absolute -->
                            @foreach (App\Models\Role::all() as $role)
                                <li>
                                    <a href="{{ route('admin.iso.komponen', ['id' => $id, 'role_id' => $role->id]) }}"
                                        class="dropdown-item">
                                        {{ $role->name }} ({{ $role->id }})
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="fs-4">
                    Berkas {{ $berkas->name }}
                </div>
            </div>
            <div class="gap-2 d-flex">
                {{-- <button class="gap-1 btn btn-primary d-flex align-items-center" wire:click="changeDisplay"
                    style="padding: 10px 12px;"><i
                        class="@if ($display == 2) fas fa-th  @else fas fa-list @endif "></i></button> --}}
                @if (auth()->user()->pangkat == 0)
                    <button class="gap-1 btn btn-primary d-flex align-items-center" wire:click="toggleForm"
                        @if ($showForm) onclick="clearForm()" @endif>
                        <i class="bi {{ $showForm ? 'bi-dash' : 'bi-plus' }} fs-5"></i>
                        <span>{{ $showForm ? 'Tutup Form' : 'Tambah Komponen' }}</span>
                    </button>
                @endif
            </div>

            <script></script>
        </div>
    </div>

    <div class="border-2 border-top"
        style="overflow: hidden; max-height: {{ $showForm ? '1000px' : '0' }}; transition: all 0.3s ease;">
        <div class="p-5 border-2 border-top w-100" style="">
            <form wire:submit.prevent="submit">
                <div class="row g-3">

                    <!-- Dropdown -->
                    <div class="col-md-6 position-relative">
                        <!-- Added position-relative -->
                        <input type="hidden" id="role" name="formRole" />
                        <label for=" inputDropdown" class="form-label">Divisi</label>
                        <div class="dropdown" wire:ignore>
                            <button
                                class="px-4 border border-primary btn dropdown-toggle w-100 d-flex align-items-center justify-content-between"
                                type="button" id="inputDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $formRole == null ? 'Pilih Divisi' : '' }}
                            </button>
                            <ul style="max-height: 500px; overflow-y: auto; width: fit-content"
                                class="dropdown-menu position-fixed" aria-labelledby="inputDropdown">
                                <!-- Added position-absolute -->
                                @foreach (App\Models\Role::all() as $role)
                                    <li>
                                        <input type="hidden" id="selectedRoles-{{ $role->id }}"
                                            wire:model="selectedRoles.{{ $role->id }}" class="form-control">
                                        <button type="button" class="dropdown-item"
                                            wire:click="toggleRole({{ intval($role->id) }})"
                                            onclick="event.stopPropagation(); toggleRole({{ $role->id }})">
                                            {{ $role->name }} ({{ $role->id }})
                                            <i id="check-{{ $role->id }}"
                                                class="fas {{ in_array($role->id, $selectedRoles) ? 'fa-check' : '' }} check-component"></i>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                        @error('selectedRoles')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Input Text -->
                    <div class="col-md-6">
                        <label for="inputText" class="form-label">Nama Komponen</label>
                        <input type="text" class="form-control  @error('formName') is-invalid  @enderror"
                            id="inputText" placeholder="Nama Komponen" name="formName" wire:model="formName"
                            wire:change="onChange">
                        @error('formName')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <script>
                        function embedRole(komponenText, roles) {

                            const inp = document.getElementById('inputText');
                            inp.value = komponenText;
                            roles.forEach(role => {
                                const el = document.getElementById('check-' + role.role_id);
                                el.classList.add('fa-check');
                            });
                        }

                        function changeRoleName(roleName, roleId) {
                            document.getElementById('inputDropdown').textContent = roleName;
                            document.getElementById('role').value = roleId;
                        }

                        function toggleRole(id) {
                            const el = document.getElementById('check-' + id);
                            if (el.classList.contains('fa-check')) {
                                el.classList.remove('fa-check')
                            } else {
                                el.classList.add('fa-check')
                            }
                        }

                        function clearForm() {
                            const inp = document.getElementById('inputText');
                            inp.value = "";
                            const el = document.querySelectorAll('.fa-check.check-component');
                            el.forEach(e => {
                                e.classList.remove('fa-check')
                            });

                        }
                    </script>

                </div>

                <!-- Submit Button -->
                <div class="mt-3 d-flex justify-content-end">
                    <button type="submit"
                        class="btn btn-primary">{{ $komponenId != null ? 'Simpan Perubahan' : 'Submit' }}</button>
                </div>

                <!-- Success Message -->
                @if (session()->has('message'))
                    <div class="mt-3 alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
            </form>
        </div>
    </div>

    <div class="p-4 overflow-auto border-2">
        @if ($komponen->isNotEmpty())

            @if ($display == 1)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Divisi</th>
                            <th>Komponen</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $filteredKomponen = $komponen->filter(function ($item) use ($role_id) {
                                return in_array($role_id, $item->access->pluck('role_id')->toArray());
                            });
                        @endphp

                        @foreach ($filteredKomponen as $index => $item)
                            @if (true)
                                <tr class="@if ($loop->odd) bg-light @endif">
                                    <!-- Role Selection -->
                                    <td>
                                        <select id="roleSelect-{{ $loop->index }}" class="form-select w-100">
                                            @foreach (App\Models\Role::all() as $r)
                                                @if ($item->access->contains('role_id', $r->id))
                                                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                    <!-- Komponen Name -->
                                    <td id="komponen-{{ $loop->index }}" class="cursor-pointer"
                                        @if ($item->files($berkas->id)->where('role_id', $role_id)->get()->isNotEmpty()) onclick="toggleShowFile({{ $item->files($berkas->id)->where('role_id', $role_id)->get()->count() }}, '{{ $item->id }}')" @endif>
                                        {{ $item->name }}
                                        @if ($item->files($berkas->id)->where('role_id', $role_id)->get()->isNotEmpty())
                                            <span><i style="transition: transform 0.3s ease-in-out;"
                                                    class="cursor-pointer fas fa-chevron-down"
                                                    id="icon-komponen-{{ $item->id }}"></i></span>
                                        @endif

                                        <!-- Files Section -->
                                        <div class="px-2">
                                            @php
                                                $files = $item->files($berkas->id)->where('role_id', $role_id)->get();
                                            @endphp
                                            @if ($files->isNotEmpty())
                                                <div id="komponen-file-{{ $item->id }}"
                                                    style="transition: height 0.3s ease-in-out; overflow: hidden; height: 0px;">
                                                    @foreach ($item->files($berkas->id)->get() as $f)
                                                        <div class="gap-2 px-2 mb-2 row justify-content-between"
                                                            style="flex-wrap: nowrap;">
                                                            <input value="{{ $f->filename }}" readonly
                                                                class="overflow-auto border rounded col ms-2"
                                                                style="flex-wrap: nowrap;overflow:scroll;" />
                                                            <div class="gap-2 col d-flex">
                                                                <button class="btn btn-sm btn-secondary"
                                                                    onclick="showPdfModal('{{ $f->path }}', '{{ $f->filename }}')">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                                <button class="btn btn-sm btn-warning">
                                                                    <i class="fas fa-info-circle"></i>
                                                                </button>
                                                                <button class="btn btn-sm btn-danger">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Action Buttons -->
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-info" data-bs-toggle="modal"
                                                data-bs-target="#uploadFileModal"
                                                wire:click='selectForUpload("{{ $item->id }}")'>
                                                <i class="fas fa-plus"></i>
                                            </a>

                                            @if (auth()->user()->pangkat == 0)
                                                <a class="btn btn-secondary" wire:click="edit('{{ $item->id }}')"
                                                    onclick="embedRole('{{ $item->name }}',{{ $item->access }});">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            @endif

                                            <a class="btn btn-warning"
                                                href="{{ route('admin.iso.komponen.kelola', ['berkasId' => $berkas->id, 'komponenId' => $item->id, 'role_id' => $role_id]) }}">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <button class="btn btn-dark"
                                                wire:click="downloadZip('{{ $item->id }}', '{{ $berkas->id }}')">
                                                <i class="fas fa-download"></i>
                                            </button>

                                            @if (auth()->user()->pangkat == 0)
                                                <button class="btn btn-danger"
                                                    wire:click="confirmDelete('{{ $item->id }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>

                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @elseif($display == 2)
                <div class="grid-container">
                    @foreach ($komponen as $item)
                        <div class="grid-item">
                            <div id="komponen-{{ $loop->index }}"
                                @if ($item->files($berkas->id)->where('role_id', $role_id)->get()->isNotEmpty()) onclick="toggleShowFile('{{ $item->id }}')" @endif
                                class="cursor-pointer d-flex justify-content-between align-items-center">
                                <span>{{ $item->name }}</span>
                                <i style="transition: transform 0.3s ease-in-out;" class="fas fa-chevron-down"
                                    id="icon-komponen-{{ $item->id }}"></i>
                            </div>

                            <div class="button-container">
                                <a href="#" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                    data-bs-target="#uploadFileModal"
                                    wire:click='selectForUpload("{{ $item->id }}")'><i
                                        class="fas fa-plus"></i></a>

                                <a href="#" class="btn btn-sm btn-secondary"
                                    wire:click="edit('{{ $item->id }}')"
                                    onclick="embedRole('{{ $item->name }}',{{ $item->access }});"><i
                                        class="fas fa-pen"></i></a>

                                <a href="{{ route('admin.iso.komponen', ['id' => $item->id]) }}"
                                    class="btn btn-sm btn-warning">
                                    <i class="fas fa-info-circle"></i>
                                </a>

                                <button class="btn btn-sm btn-dark"
                                    wire:click="downloadZip('{{ $item->id }}', '{{ $berkas->id }}')">
                                    <i class="fas fa-download"></i>
                                </button>

                                <button class="btn btn-sm btn-danger"
                                    wire:click="confirmDelete('{{ $item->id }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <div class="hidden" id="komponen-file-{{ $item->id }}">
                                @foreach ($item->files($berkas->id)->get() as $f)
                                    <div class="form-control">{{ $f->filename }}</div>
                                    <div class="button-container">
                                        <button class="btn btn-sm btn-secondary"
                                            onclick="showPdfModal('{{ $f->path }}', '{{ $f->filename }}')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a class="btn btn-sm btn-warning"><i class="fas fa-info-circle"></i></a>
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @else
            <div class="py-3 text-center text-muted">
                Belum ada komppnen yang ditambahkan
            </div>
        @endif
    </div>


    <!-- Modal for File Upload -->
    <div wire:ignore.self class="modal fade" id="uploadFileModal" tabindex="-1"
        aria-labelledby="uploadFileModalLabel" aria-hidden="true">
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
                            <input type="hidden" wire:model='selectedFile' name="selectedFile" id="selectedFile" />
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

    <!-- JavaScript to Handle Dynamic Modal Content -->
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
        function toggleShowFile(count, id) {
            console.log(count);
            const komponenFile = document.getElementById('komponen-file-' + id);
            const komponenIcon = document.getElementById('icon-komponen-' + id);

            if (komponenFile.classList.contains('expand')) {
                komponenFile.style.height = komponenFile.scrollHeight + 'px';
                setTimeout(() => {
                    komponenFile.style.height = '0px';
                }, 10);
                komponenFile.classList.remove('expand');

                komponenIcon.style.transform = 'rotate(0deg)'; // Rotate back
            } else {
                komponenFile.style.height = komponenFile.scrollHeight + 'px';
                komponenFile.classList.add('expand');

                setTimeout(() => {
                    komponenFile.style.height = 'auto';
                }, 300);

                komponenIcon.style.transform = 'rotate(180deg)'; // Rotate down
            }

        }
    </script>

    <script>
        window.addEventListener('file-uploaded', event => {
            var closeButton = document.getElementById('closeModal');
            closeButton.click();
        });
    </script>


</div>

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
        </ol>
    </nav>
    <div class="border card">
        <div class="card-body">
            <div class="mb-0 d-flex justify-content-between align-items-center">
                <div><a href="{{ route('admin.akreditasi.komponen', ['id' => $berkas_id, 'role_id' => -1]) }}"
                        class="btn btn-primary d-flex align-items-center"><i class="px-2 fas fa-chevron-left"></i><span
                            class="d-none d-md-block">Kembali</span></a></div>
                <div class="mb-2 text-2xl gk-text-base-black d-flex align-items-center" style="flex-direction: column">
                    <div class="font-bold">
                        <div class="dropdown">

                            <div class="text-center" style="cursor: pointer;" aria-expanded="false">
                                Aspek Komponen
                            </div>
                            <div class="text-center font-normal" style="cursor: pointer; font-size: 19px;"
                                aria-expanded="false">
                                Komponen {{ App\Models\Komponen::findOrFail($komponen_id)->name }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gap-2 d-flex">
                    {{-- <button class="gap-1 btn btn-primary d-flex align-items-center" wire:click="changeDisplay"
                        style="padding: 10px 12px;"><i
                            class="@if ($display == 2) fas fa-th  @else fas fa-list @endif "></i></button> --}}
                    @if (auth()->user()->pangkat == 0)
                        <button data-bs-toggle="modal" data-bs-target="#berkasModal"
                            class="gap-1 btn btn-primary d-flex align-items-center" wire:click="toggleForm"
                            @if ($showForm) onclick="clearForm()" @endif>
                            <i class="bi {{ $showForm ? 'bi-dash' : 'bi-plus' }} fs-5"></i>
                            <span>Tambah Aspek</span>
                        </button>
                    @endif
                </div>

                <script></script>
            </div>
        </div>
        <div class="border-2 border-top" style="overflow: hidden; max-height: 0; transition: all 0.3s ease;">
            <div class="p-5 border-2 border-top w-100" style="">
                <x-modal id="berkasModal" title="Tambah Berkas">
                    <form wire:submit.prevent="submit">
                        <div class="row g-3">

                            <!-- Dropdown -->
                            <!-- Input Text -->
                            <div class="col-md">
                                <label for="inputText" class="form-label">Nama Aspek</label>
                                <input type="text" class="form-control  @error('formName') is-invalid  @enderror"
                                    id="inputText" placeholder="Nama Aspek" name="formName" wire:model="formName">
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
                                class="btn btn-primary">{{ $komponen_id != null ? 'Simpan Perubahan' : 'Submit' }}</button>
                        </div>

                        <!-- Success Message -->
                        @if (session()->has('message'))
                            <div class="mt-3 alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                    </form>
                </x-modal>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const formBerkas = document.getElementById("formBerkas");
                        formBerkas.addEventListener("submit", (event) => {
                            // If using Livewire, let Livewire handle the request first.
                            // Option 1: Let Livewire/validation handle, close modal from Livewire via event (best practice)
                            // Option 2: If you want to close instantly after submit (not best for async), uncomment below:
                            // var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('berkasModal'));
                            // modal.hide();
                        });
                    });

                    // Best Practice: Listen for a Livewire event to close the modal only if submit is successful
                    window.addEventListener('close-modal', event => {
                        var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('berkasModal'));
                        modal.hide();
                    });
                </script>
                <x-modal id="subAspek" title="Tambah Berkas">
                    <form wire:submit.prevent="subAspekForm">
                        <div class="row g-3">

                            <!-- Dropdown -->
                            <!-- Input Text -->
                            <div class="col-md">
                                <label for="inputText" class="form-label">Nama Sub-Aspek</label>
                                <input type="text" class="form-control  @error('formName') is-invalid  @enderror"
                                    id="inputText" placeholder="Nama Sub-Aspek" name="subAspekName"
                                    wire:model="subAspekName">
                                @error('subAspekName')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-3 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>

                        <!-- Success Message -->
                        @if (session()->has('message'))
                            <div class="mt-3 alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                    </form>
                </x-modal>
                <script>
                    // Best Practice: Listen for a Livewire event to close the modal only if submit is successful
                    window.addEventListener('close-modal', event => {
                        var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('subAspek'));
                        modal.hide();
                    });
                </script>
            </div>
        </div>

        <div class="p-4 overflow-auto border-2">
            <div class="p-3">
                <div class="row fs-4 text-dark">
                    <ul class="col-2">
                        <li>Aspek Komponen</li>
                        <li>Skor Maksimum</li>
                        <li>Bobot</li>
                    </ul>
                    <ul class="col-2">
                        <li>: {{ App\Models\Komponen::findOrFail($komponen_id)->name }}</li>
                        <li>: {{ App\Models\Komponen::findOrFail($komponen_id)->skor }}</li>
                        <li>: {{ App\Models\Komponen::findOrFail($komponen_id)->bobot }}</li>
                    </ul>
                </div>

            </div>
            @if ($aspek->isNotEmpty())
                <table class="table">
                    <thead>
                        <tr>
                            <th class="d-flex justify-content-center align-items-center" align="center">No</th>
                            <th>Aspek</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($aspek as $k)
                            <tr class="@if ($loop->odd) bg-light @endif">
                                <td class="d-flex justify-content-center align-items-center" align="center">
                                    <div class="cursor-pointer h-100 p-1 rounded-2 rounded-end-0 "
                                        @if ($k->no - 1 == 0) style="background-color: gray; border: 2px solid gray; border-right: none;"
                                        @else style="background-color: black; border: 2px solid black; border-right: none;" wire:click='changeDirection("{{ $k->id }}",1)' @endif>
                                        <i class="fa fa-chevron-up text-light"></i>
                                    </div>
                                    {{-- <div class="cursor-pointer border border-dark h-100 px-3 p-1 ">{{ $k->no }}
                                    </div> --}}
                                    <div class="cursor-pointer h-100  p-1 rounded-2 rounded-start-0"
                                        @if ($k->no == $aspek->count()) style="background-color: gray; border: 2px solid gray; border-left: none;"
                                        @else style="background-color: black; border: 2px solid black; border-left: none;" wire:click='changeDirection("{{ $k->id }}",-1)' @endif>
                                        <i class="fa fa-chevron-down text-light"></i>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex" style="flex-wrap: nowrap;">
                                        <div class="border border-dark text-dark rounded-2 @if (count(App\Models\SubAspek::where('aspek_id', $k->id)->get()) != 0) rounded-end-0 @endif p-1 h-100"
                                            style="max-width: 500px; width: 100%;flex-wrap: nowrap; white-space: nowrap;
">
                                            {{ $k->no }}. {{ $k->name }}
                                        </div>
                                        @if (count(App\Models\SubAspek::where('aspek_id', $k->id)->get()) > 0)
                                            <div wire:click="showAspek('{{ $k->id }}')"
                                                class="cursor-pointer border border-dark h-100 bg-dark p-1 px-3 rounded-2 rounded-start-0"
                                                style="">
                                                <i class="fa fa-chevron-down text-light"></i>
                                            </div>
                                        @endif
                                    </div>

                                    @if (count(App\Models\SubAspek::where('aspek_id', $k->id)->get()) > 0)
                                        <div class="overflow-hidden"
                                            style="max-width: 550px; {{ $k->id === $showingAspek ? 'max-height: 500px; opacity: 1; margin-top: 10px;' : 'max-height: 0; opacity: 0; margin-top: 0px;' }} transition: max-height 0.3s ease, opacity 0.3s ease;">
                                            <ul class="ps-0">
                                                @foreach (App\Models\SubAspek::where('aspek_id', $k->id)->get() as $sub)
                                                    <li
                                                        class="py-1 px-1 border-bottom border-dark d-flex justify-content-between align-items-center">
                                                        {{ $sub->name }}
                                                        <div>
                                                            @if (auth()->user()->pangkat == 0)
                                                                <a class="btn btn-sm btn-secondary"
                                                                    data-bs-toggle="modal" data-bs-target="#subAspek"
                                                                    wire:click="editSubAspek('{{ $sub->id }}')">
                                                                    <i class="fas fa-pen"></i>
                                                                </a>
                                                            @endif
                                                            @if (auth()->user()->pangkat == 0)
                                                                <button class="btn btn-sm btn-danger"
                                                                    wire:click="sub_delete('{{ $sub->id }}')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                </td>
                                <td>
                                    <div class="" style="flex-wrap: nowrap;white-space: nowrap;">
                                        <a class="btn btn-sm btn-dark"
                                            href="{{ route('admin.akreditasi.sub-aspek', ['berkas_id' => $berkas_id, 'komponen_id' => $komponen_id, 'aspek_id' => $k->id]) }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if (auth()->user()->pangkat == 0)
                                            <a class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#subAspek"
                                                wire:click="chooseAspek('{{ $k->id }}')">
                                                <i class="fas fa-plus"></i> <span class="d-md-inline d-none">Tambah
                                                    Sub-Aspek</span>
                                            </a>
                                        @endif
                                        @if (auth()->user()->pangkat == 0)
                                            <a class="btn btn-sm btn-secondary" data-bs-toggle="modal"
                                                data-bs-target="#berkasModal"
                                                wire:click="edit('{{ $k->id }}')"
                                                onclick="embedRole('{{ $k->name }}',{{ $k->access }});">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                        @endif
                                        @if (auth()->user()->pangkat == 0)
                                            <button class="btn btn-sm btn-danger"
                                                wire:click="confirmDelete('{{ $k->id }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
                                "<strong>{{ $confirmingDelete != null ? $confirmingDelete->name : 'Nama Berkas' }}</strong>"
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

        @if ($sub_del != null)
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
                                "<strong>{{ $sub_del != null ? $sub_del->name : 'Nama Berkas' }}</strong>"
                                untuk
                                mengonfirmasi penghapusan:</p>
                            <input type="text" class="form-control" wire:model="confirmingDeleteText">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="cancelDelete">Batal</button>
                            <button type="button" class="btn btn-danger" wire:click="delete_subaspek">Hapus</button>
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

</div>

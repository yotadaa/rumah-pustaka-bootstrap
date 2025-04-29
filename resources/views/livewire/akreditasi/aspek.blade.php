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
                            <div class="text-center font-normal" style="cursor: pointer; font-size: 19px;" aria-expanded="false">
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
                        <button class="gap-1 btn btn-primary d-flex align-items-center" wire:click="toggleForm"
                            @if ($showForm) onclick="clearForm()" @endif>
                            <i class="bi {{ $showForm ? 'bi-dash' : 'bi-plus' }} fs-5"></i>
                            <span>{{ $showForm ? 'Tutup Form' : 'Tambah Aspek' }}</span>
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
            </div>
        </div>

        <div class="p-4 overflow-auto border-2">
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
                                    <div class="cursor-pointer border border-dark h-100 px-3 p-1 ">{{ $k->no }}
                                    </div>
                                    <div class="cursor-pointer h-100  p-1 rounded-2 rounded-start-0"
                                        @if ($k->no == $aspek->count()) style="background-color: gray; border: 2px solid gray; border-left: none;"
                                        @else style="background-color: black; border: 2px solid black; border-left: none;" wire:click='changeDirection("{{ $k->id }}",-1)' @endif>
                                        <i class="fa fa-chevron-down text-light"></i>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div class="border border-dark text-dark rounded-2 rounded-end-0 p-1 h-100"
                                            style="max-width: 500px; width: 100%; border-end-start-radius: 0;">
                                            {{ $k->name }}
                                        </div>
                                        <div class="cursor-pointer border border-dark h-100 bg-dark p-1 px-3 rounded-2 rounded-start-0"
                                            style="">
                                            <i class="fa fa-chevron-down text-light"></i>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-dark"
                                            href="{{ route('admin.akreditasi.indikator', ['berkas_id' => $berkas_id, 'komponen_id' => $komponen_id, 'aspek_id' => $k->id]) }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if (auth()->user()->pangkat == 0)
                                            <a class="btn btn-sm btn-secondary"
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

</div>

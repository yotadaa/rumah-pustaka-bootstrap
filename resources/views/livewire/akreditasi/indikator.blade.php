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

                            <div class="text-center" style="cursor: pointer;" aria-expanded="false">Indikator Akreditasi
                            </div>
                            <div class="text-center font-normal small" style="cursor: pointer;" aria-expanded="false">
                                {{ App\Models\Aspek::findOrFail($aspek_id)->name }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gap-2 d-flex">
                    {{-- <button class="gap-1 btn btn-primary d-flex align-items-center" wire:click="changeDisplay"
                        style="padding: 10px 12px;"><i
                            class="@if ($display == 2) fas fa-th  @else fas fa-list @endif "></i></button> --}}
                    @if (auth()->user()->pangkat == 0)
                        <button class="gap-1 btn btn-primary d-flex align-items-center" wire:click="toggleForm">
                            <i class="bi bi-plus fs-5"></i>
                            <span>Tambah Aspek</span>
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

                        <div class="hs-docs-content-divider">

                            <!--Include the JS & CSS-->
                            <link rel="stylesheet"
                                href="{{ asset('rich-text-editor/richtexteditor/rte_theme_default.css') }}" />
                            <script type="text/javascript" src="{{ asset('rich-text-editor/richtexteditor/rte.js') }}"></script>
                            <script>
                                RTE_DefaultConfig.url_base = 'richtexteditor'
                            </script>
                            <script type="text/javascript" src='{{ asset('rich-text-editor/richtexteditor/plugins/all_plugins.js') }}'></script>
                            <div id="div_editor1">
                                <p>This is a default toolbar demo of Rich text editor.</p>
                                <p><img src='{{ asset('rich-text-editor/images/editor-image.png') }}' /></p>
                            </div>

                            <script>
                                var editor1 = new RichTextEditor("#div_editor1");
                                //editor1.setHTMLCode("Use inline HTML or setHTMLCode to init the default content.");
                            </script>

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
        @push('scripts')
            <script src="{{ asset('rich-text-editor/res/patch.js') }}"></script>
        @endpush

    </div>
</div>

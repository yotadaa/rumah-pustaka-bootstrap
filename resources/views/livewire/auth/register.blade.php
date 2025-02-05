<div class="py-0 my-0 d-lg-flex justify-content-center">
    <div class="order-1 bg order-md-2" style="background-image: url('{{ asset('componen/login/images/bg_1.jpg') }}');">
    </div>
    <div class="    ">

       <div class="card">
            <div class="py-5 card-body">
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-7">
                            <figure>
                                <img src="{{ asset('logo.png') }}" class="mb-2 w-100" />
                            </figure>
                            <h3>Register to <strong>Perpustakaan Universitas Jambi</strong></h3>
                            <p class="mb-4">Silahkan isi informasi akun anda di bawah.</p>
                            <form wire:submit.prevent="register" method="post">
                                <div class="form-group first">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        placeholder="your-email@gmail.com" id="email" name="email" wire:model="email" />
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Your Password" id="password" name="password" wire:model="password" />
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group last">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        placeholder="Confirm Your Password" id="password_confirmation"
                                        name="password_confirmation" wire:model="password_confirmation" />
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mt-2 w-100" style="width: 100%;">
                                    <!-- Added position-relative -->
                                    <div class="dropdown w-100" >
                                        <button style="width: 100%;"
                                            class="px-4 border border-primary btn dropdown-toggle d-flex align-items-center justify-content-between" @if ($allRole) disabled @endif
                                            type="button" id="inputDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ $formRole == null ? 'Pilih Role' : '' }}
                                        </button>
                                        <ul wire:ignore style="max-height: 500px; overflow-y: auto; width: fit-content"
                                            class="dropdown-menu " aria-labelledby="inputDropdown">
                                            <!-- Added position-absolute -->
                                            @foreach ($roles as $role)
                                                <li>
                                                    <input type="hidden" id="selectedRoles-{{ $role->id }}"
                                                        wire:model="selectedRoles.{{ $role->id }}" class="form-control">
                                                    <button type="button"
                                                        class="{{ in_array($role->id, $selectedRoles) ? 'checked' : '' }} dropdown-item"
                                                        id="check-{{ $role->id }}"
                                                        style="background: {{ in_array($role->id, $selectedRoles) ? 'red' : '' }};"
                                                        wire:click="toggleRole({{ intval($role->id) }})"
                                                        onclick="event.stopPropagation(); toggleRole({{ $role->id }})">
                                                        {{ $role->name }} ({{ $role->id }})
                                                    </button>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @error('selectedRoles')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button style="width: 100%;"
                                            class="px-4 mt-2 border {{$allRole ? 'btn-primary' : 'border-primary'}}  btn d-flex align-items-center justify-content-between"
                                            type="button" wire:click="toggleAllRole">
                                            Semua Role
                                        </button>

                                <script>
                                    function embedRole(komponenText, roles) {

                                        const inp = document.getElementById('inputText');
                                        inp.value = komponenText;
                                        roles.forEach(role => {
                                            const el = document.getElementById('check-' + role.role_id);
                                            el.classList.add('checked');
                                        });
                                    }

                                    function changeRoleName(roleName, roleId) {
                                        document.getElementById('inputDropdown').textContent = roleName;
                                        document.getElementById('role').value = roleId;
                                    }

                                    function toggleRole(id) {
                                        const el = document.getElementById('check-' + id);
                                        if (el.classList.contains('checked')) {
                                            el.classList.remove('checked');
                                            el.style.background = "transparent";
                                        } else {
                                            el.classList.add('checked')
                                            el.style.background = "gray";
                                        }
                                    }

                                    function clearForm() {
                                        const inp = document.getElementById('inputText');
                                        inp.value = "";
                                        const el = document.querySelectorAll('.checked');
                                        el.forEach(e => {
                                            e.classList.remove('checked');
                                            el.style.background = "transparent";
                                        });

                                    }
                                </script>

                                <div class="mb-5 d-flex align-items-center">
                                    <span class="ml-auto"><a href="#" class="forgot-pass">Lupa Password</a></span>
                                </div>

                                <button type="submit" class="py-2 btn btn-block btn-primary w-100" wire:loading.attr="disabled" wire:target="register">
                                    <span wire:loading.remove wire:target="register">Daftar</span>
                                    <span wire:loading wire:target="register">
                                        <i class="fa fa-spinner fa-spin"></i> Memproses...
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
       </div>
    </div>
</div>

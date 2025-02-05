<div class="p-5 border-2 border-top w-100" style="">
    <form wire:submit.prevent="submit">
        <div class="row g-3">
            <!-- Input Text -->
            <div class="col-md-6">
                <label for="inputText" class="form-label">Nama Komponen</label>
                <input type="text" class="form-control" id="inputText" placeholder="Nama Komponen" wire:model="name">
                @error('name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Dropdown -->
            <div class="col-md-6">
                <label for="inputDropdown" class="form-label">Role</label>
                <div class="dropdown position-relative" wire:ignore>
                    <button
                        class="px-4 border border-primary btn dropdown-toggle w-100 d-flex align-items-center justify-content-between"
                        type="button" id="inputDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ $selectedOption ?? 'Pilih Role' }}
                    </button>
                    <ul class="dropdown-menu w-100" aria-labelledby="inputDropdown"
                        style="position: absolute; z-index: 9999;">
                        <li>
                            <button type="button" class="dropdown-item" wire:click="">Option 1</button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item" wire:click="">Option 2</button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item" wire:click="">Option 3</button>
                        </li>
                    </ul>
                </div>
                @error('option')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


        </div>

        <!-- Submit Button -->
        <div class="mt-3 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>

        <!-- Success Message -->
        @if (session()->has('message'))
        <div class="mt-3 alert alert-success">
            {{ session('message') }}
        </div>
        @endif
    </form>
</div>

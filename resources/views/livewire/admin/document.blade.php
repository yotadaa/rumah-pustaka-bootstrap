<div class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-start justify-content-center p-4"
    style="z-index: 1050;
        opacity: {{ $document['id'] != null ? '1' : '0' }};
        visibility: {{ $document['id'] != null ? 'visible' : 'hidden' }};
        transition: opacity 0.3s ease, visibility 0.3s ease;
    ">
    <div class="bg-white w-100 h-100 rounded shadow p-4"
        style="opacity: {{ $document['id'] != null ? '1' : '0' }};
        visibility: {{ $document['id'] != null ? 'visible' : 'hidden' }};
        transition: opacity 0.3s ease, visibility 0.3s ease;">
        <!-- Your content goes here -->
        <h1 class="h4"><i class="fas fa-file"></i>&nbsp;&nbsp;Dokumen Indikator</h1>
        <hr>
        <div class="d-flex gap-2">
            <button class="btn btn-danger" wire:click="closePage">
                Tutup
            </button>
            <div>
                @if (session()->has('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                <input type="file" wire:model="file" class="d-none" id="docUploadInput">

                <button class="btn btn-primary" onclick="document.getElementById('docUploadInput').click()">
                    📄 Upload Document
                </button>

                @error('document')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror

                @if ($file)
                    <div class="mt-2">
                        <strong>Uploading:</strong> {{ $file->getClientOriginalName() }}
                    </div>
                @endif
            </div>
        </div>
        <div class="d-flex flex-wrap gap-3 my-4">
            @foreach ($all_document as $key => $doc)
                <div class="border border-info shadow rounded p-2 text-center" style="width: 150px;">
                    {{-- Icon based on extension --}}
                    @php
                        $ext = strtolower(pathinfo($doc['filename'], PATHINFO_EXTENSION));
                        $filesize = filesize(public_path($doc['path'])); // Get file size
                        $icon = match ($ext) {
                            'pdf' => '📄',
                            'doc', 'docx' => '📝',
                            'xls', 'xlsx' => '📊',
                            'ppt', 'pptx' => '投影',
                            'jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp' => '🖼️',
                            default => '📁',
                        };
                    @endphp

                    <div style="font-size: 2.5rem;">{{ $icon }}</div>

                    {{-- Filename --}}
                    <div class="text-truncate" title="{{ $doc['filename'] }}">
                        {{ $doc['filename'] }}
                    </div>

                    {{-- File size --}}
                    <div class="small text-muted">
                        {{ round($filesize / 1024, 2) }} KB
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-2">
                        {{-- View Button --}}
                        <a href="{{ asset($doc['path']) }}" target="_blank" class="btn btn-sm btn-outline-primary"
                            title="View File">
                            <i class="fas fa-eye"></i>
                        </a>

                        {{-- Dropdown Menu --}}
                        <div class="btn-group">
                            <button type="button"
                                class="btn btn-sm btn-outline-secondary dropdown-toggle dropdown-toggle-split"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                {{-- Rename Action --}}
                                <li>
                                    <a class="dropdown-item" href="#" wire:click.prevent="">
                                        <i class="fas fa-pencil-alt me-2"></i>Rename
                                    </a>
                                </li>
                                {{-- Delete Action --}}
                                <li>
                                    <a class="dropdown-item text-danger" href="#"
                                        wire:click="delete_file('{{ $doc['id'] }}')">
                                        <i class="fas fa-trash me-2"></i>Delete
                                    </a>
                                </li>
                                {{-- Download Action --}}
                                <li>
                                    <a class="dropdown-item" href="{{ asset($doc['path']) }}" download>
                                        <i class="fas fa-download me-2"></i>Download
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Font Awesome CDN (if not already included) --}}
        {{-- Make sure you have Font Awesome included in your main layout file for the icons to work --}}
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" /> --}}
        {{-- Bootstrap JS Bundle (if not already included) --}}
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}

    </div>
</div>

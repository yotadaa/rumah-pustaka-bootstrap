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
            @foreach ($all_document as $doc)
                <div class="border border-info shadow rounded p-2 text-center" style="width: 120px;">
                    {{-- Ikon berdasarkan ekstensi --}}
                    @php
                        $ext = strtolower(pathinfo($doc['filename'], PATHINFO_EXTENSION));
                        $icon = match ($ext) {
                            'pdf' => '📄',
                            'jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp' => '🖼️',
                            default => '📁',
                        };
                    @endphp

                    <div style="font-size: 2rem;">{{ $icon }}</div>

                    {{-- Nama file --}}
                    <div class="text-truncate" title="{{ $doc['filename'] }}">
                        {{ $doc['filename'] }}
                    </div>

                    {{-- Skor --}}
                    {{-- <div class="small text-muted">Skor: {{ $doc['score'] ?? 1 }}</div>  --}}

                    {{-- Link preview/download --}}
                    <a href="{{ asset($doc['path']) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                        Lihat
                    </a>
                </div>
            @endforeach
        </div>

    </div>
</div>

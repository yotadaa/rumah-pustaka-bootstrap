@push('styles')
    <style>
        /* Custom Styles */
        body {
            background-color: #f8f9fa;
            /* A light grey background */
        }

        .main-header {
            padding: 1.5rem;
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
        }

        .stat-card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        .stat-card .card-body {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-card-icon {
            font-size: 2rem;
            color: #0d6efd;
            /* Bootstrap primary blue */
        }

        .stat-card-info h3 {
            font-size: 1.75rem;
            font-weight: 700;
        }

        .stat-card-info p {
            font-size: 0.9rem;
            color: #6c757d;
            /* Bootstrap secondary text color */
            margin-bottom: 0;
        }

        .stat-card-growth {
            color: #198754;
            /* Bootstrap success green */
            font-weight: 600;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }
    </style>

    <style>
        .stat-card {
            border: none;
            /* Menghapus border default */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            /* Efek sedikit terangkat saat hover */
            box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.25) !important;
        }

        .stat-card .card-body {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Mengatur agar semua teks dan ikon di dalam kartu gradient menjadi putih */
        .gradient-card .stat-card-icon,
        .gradient-card .stat-card-info h3,
        .gradient-card .stat-card-info p {
            color: #ffffff;
        }

        /* Ukuran ikon dan teks */
        .stat-card-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }

        .stat-card-info h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stat-card-info p {
            font-size: 0.9rem;
            margin-bottom: 0;
            opacity: 0.9;
        }

        /* == GRADIENT CLASSES == */
        /* Gradient 1: Biru ke Ungu */
        .gradient-1 {
            background-image: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        /* Gradient 2: Hijau ke Biru */
        .gradient-2 {
            background-image: linear-gradient(135deg, #2AF598 0%, #009EFD 100%);
        }

        /* Gradient 3: Kuning ke Oranye */
        .gradient-3 {
            background-image: linear-gradient(135deg, #F6D365 0%, #FDA085 100%);
        }

        /* Gradient 4: Pink ke Oranye */
        .gradient-4 {
            background-image: linear-gradient(135deg, #FE6B8B 0%, #FF8E53 100%);
        }

        .progress-bar-gradient {
            /* Menghapus warna background default agar gradient terlihat */
            background-color: transparent;

            /* Membuat gradient dari kiri (biru) ke kanan (hijau) */
            background-image: linear-gradient(to right, #2096ff, #05ffa3);

            /* Menambahkan sedikit bayangan agar terlihat lebih menonjol */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
        }
    </style>
@endpush

<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-2" style="flex-wrap: wrap; overflow-x: auto;">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
        </ol>
    </nav>
    <div class="border card">
        <div class="card-body row">
            <div class="dropdown my-2">
                <button class="btn btn-outline-dark col-12 col-md-2 dropdown-toggle" type="button" id="berkasDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    {{ $berkas_label }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="berkasDropdown">
                    @foreach ($berkas as $item)
                        <li>
                            <button class="dropdown-item" wire:click="changeBerkas('{{ $item->id }}')">
                                {{ $item->name }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- <div class="row col-12">
                <div class="col-12  col-sm-2 h-100">
                    <div class="rounded-2 h-100 shadow text-center border-1 "
                        style="background: radial-gradient(circle, rgba(242,247,255,1), #B2CBDF);">
                        <x-radial-chart data="95" id="all_scores" />
                    </div>
                </div>
                <div class="col-12  col-sm-6 h-100">
                    <div class="col-12 col-md-12 h-100 text-light w-bold fs-4 rounded-top border border-dark p-0 rounded-2"
                        style="overflow-y:hidden">
                        <div class="col-12 text-light p-2 fw-bold fs-4 rounded-top"
                            style="background: linear-gradient(to right, #5C9DE8, #3F90D3);">
                            Komponen
                            dengan Skor Tertinggi</div>
                        <div style="background: linear-gradient(to right, #FFFFFF, #B2CBDF);"
                            class=" h-100 col-12 p-4  rounded-bottom fs-6 fw-bold">
                            <div class="row">
                                <div class="col-12 ">
                                    <div class="text-dark col-12 fs-7">
                                        @php
                                            $highest = $grouped_scores->sortByDesc('skor')->first();
                                        @endphp
                                        {{ $highest['name'] }}
                                    </div>
                                </div>
                            </div>
                            <div class="row gap-1">
                                <div class="col-12 flex-wrap">
                                    <div class="fs-5 btn btn-outline-success shadow btn-sm">
                                        {{ round($highest['indikator'] == 0 ? 0 : $highest['skor'] / $highest['indikator'], 1) }}
                                    </div>
                                    <div class="fs-5 btn btn-outline-info shadow btn-sm">{{ $highest['skor'] }} Poin
                                        Kumulatif</div>
                                    <div class="fs-5 btn btn-outline-danger shadow btn-sm">35 %</div>
                                    <div class="fs-5 btn btn-danger shadow btn-sm">
                                        {{ $highest['filled'] }}/{{ $highest['indikator'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12  col-sm-2">
                    <div class="rounded bg-primary text-dark"
                        style="width: 100%;height: 100%;background: radial-gradient(circle, rgba(242,247,255,1), #B2CBDF);">
                        <div class="col-12 p-1 h-100">
                            <div class=" col-12 fs-5 h-100 p-0 gap-0 text-center fw-bold"> Total Poin
                                <div class=" fs-12 h-50 p-0 m-0 d-flex justify-content-center align-items-end "
                                    style="font-weight: 600;">
                                    720
                                    <span class=" fs-8 m-0" style="font-weight: 600;">
                                        /
                                    </span>
                                    <span class=" fs-8 m-0" style="font-weight: 600;">
                                        2334
                                    </span>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="col-12  col-sm-2">
                    <div class="rounded bg-primary"
                        style="width: 100%;height: 100%;background: radial-gradient(circle, rgba(242,247,255,1), #B2CBDF);">
                        <div class="col-12 p-1 h-100 text-dark">
                            <div class="text-center col-12 fs-5 h-100 p-0 gap-0 fw-bold"> Indikator
                                <div class=" fs-12 h-50 p-0 m-0 d-flex text-dark justify-content-center align-items-end "
                                    style="font-weight: 600">
                                    23
                                    <span class=" fs-8 m-0" style="font-weight: 600;">
                                        /
                                    </span>
                                    <span class=" fs-8 m-0" style="font-weight: 600;">
                                        54
                                    </span>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div> --}}

            <div class="container-fluid">

                <main class="p-4">
                    <div class="row g-4">

                        <div class="col-md-6 col-lg-3">
                            <div class="card stat-card shadow gradient-card gradient-1">
                                <div class="card-body">
                                    <div class="stat-card-icon">
                                        <i class="bi bi-graph-up-arrow"></i>
                                    </div>
                                    <div class="stat-card-info text-end">
                                        <h3>{{ $total_progress }}%</h3>
                                        <p>Total Progress</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="card stat-card shadow gradient-card gradient-2">
                                <div class="card-body">
                                    <div class="stat-card-icon">
                                        <i class="bi bi-grid-3x3-gap-fill"></i>
                                    </div>
                                    <div class="stat-card-info text-end">
                                        <h3>{{ \App\Models\Komponen::where('model', 'akreditasi')->count() }} Komponen
                                        </h3>
                                        <p>Total Komponen</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="card stat-card shadow gradient-card gradient-3">
                                <div class="card-body">
                                    <div class="stat-card-icon">
                                        <i class="bi bi-columns-gap"></i>
                                    </div>
                                    <div class="stat-card-info text-end">
                                        <h3>{{ \App\Models\Aspek::all()->count() }} Aspek</h3>
                                        <p style="font-weight: 600;">{{ \App\Models\SubAspek::all()->count() }}
                                            Sub-Aspek</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="card stat-card shadow gradient-card gradient-4">
                                <div class="card-body">
                                    <div class="stat-card-icon">
                                        <i class="bi bi-card-checklist"></i>
                                    </div>
                                    <div class="stat-card-info text-end">
                                        <h3 class="" style="font-weight: 900;">
                                            {{ \App\Models\Indikator::all()->count() }} Indikator</h3>
                                        <p class="fw-bold"><strong>{{ $choosen_indikator->count() }}</strong> Terisi
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </main>
            </div>

            <div class="p-3">
                <h3>Summary Komponen</h3>

                <div class="row g-3">
                    @if ($grouped_scores != null)
                        @foreach ($grouped_scores->sortBy('name') as $gr)
                            <div class="col-12 col-xl-6">

                                <div
                                    class="p-3 border border-success shadow stat-card rounded bg-white d-block d-md-flex justify-content-between align-items-md-center w-100">

                                    <div class="flex-grow-1 me-md-3">
                                        <div class="fw-bold">
                                            {{ $gr['name'] }}
                                            <a href="{{ route('admin.akreditasi.aspek', ['berkas_id' => $berkas_id, 'komponen_id' => $gr['id']]) }}"
                                                target="_blank" class="ms-1 text-primary">
                                                <i class="fas fa-up-right-from-square fa-xs"></i>
                                            </a>
                                        </div>
                                        <div class="progress mt-1" style="height: 10px;">
                                            <div class="progress-bar progress-bar-gradient" role="progressbar"
                                                style="width: {{ $gr['maksimum_skor'] * $gr['indikator'] == 0 ? 0 : ($gr['skor'] / ($gr['maksimum_skor'] * $gr['indikator'])) * 100 }}%;"
                                                aria-valuenow="{{ $gr['skor'] }}" aria-valuemin="0"
                                                aria-valuemax="{{ $gr['maksimum_skor'] * $gr['indikator'] }}">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="btn-group mt-2 col-12 col-md-5 ">

                                        <button style="min-width:80px;" class="btn btn-outline-dark"
                                            data-bs-toggle="tooltip" title="Poin Komponen">

                                            {{-- {{ round($gr['maksimum_skor'] * $gr['indikator'] == 0 ? 0 : ($gr['skor'] / ($gr['maksimum_skor'] * $gr['indikator'])) * 100, 2) }}% --}}

                                            {{ round($gr['indikator'] == 0 ? 0 : $gr['skor'] / $gr['indikator'], 1) }}

                                        </button>

                                        <button style="min-width:100px;" class="btn btn-outline-dark"
                                            data-bs-toggle="tooltip"
                                            title="Total Poin">{{ $gr['skor'] }}/{{ $gr['maksimum_skor'] * $gr['indikator'] }}</button>

                                        <button style="min-width:80px;" class="btn btn-outline-dark"
                                            data-bs-toggle="tooltip" title="Progress Indikator">

                                            {{ $gr['filled'] }} / {{ $gr['indikator'] }}

                                        </button>



                                    </div>

                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <script>
                // Pastikan script ini dijalankan setelah DOM selesai dimuat
                document.addEventListener("DOMContentLoaded", function() {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                });
            </script>
        </div>

    </div>
</div>


{{-- @push('scripts')
    <script src="{{ asset('js/apexcharts.min.js') }}"></script>
@endpush --}}

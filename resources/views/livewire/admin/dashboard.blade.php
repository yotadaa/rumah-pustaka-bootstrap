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

            <div class="row col-12">
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

            </div>
            <div class="p-3">
                <h3>Summary Komponen</h3>
                @foreach ($grouped_scores->sortBy('name') as $gr)
                    <div
                        class="p-2 col-6 btn btn-light flex-wrap text-start border shadow border-dark rounded mb-2 d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1 me-3">
                            <div>{{ $gr['name'] }}
                                <a href="{{ route('admin.akreditasi.aspek', ['berkas_id' => $berkas_id, 'komponen_id' => $gr['id']]) }}"
                                    target="_blank">
                                    <i class="fas fa-up-right-from-square"></i>
                                </a>
                            </div>
                            <div class="progress mt-1 shadow border border-dark" style="height: 10px; width: 100%;">
                                <div class="shadow progress-bar  bg-primary" role="progressbar"
                                    style="width: {{ $gr['maksimum_skor'] * $gr['indikator'] == 0 ? 0 : ($gr['skor'] / ($gr['maksimum_skor'] * $gr['indikator'])) * 100 }}%;"
                                    aria-valuenow="{{ 90 }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                        <div class="btn-group mt-2 ">
                            <button style="min-width:80px;" class="btn btn-outline-dark">
                                {{-- {{ round($gr['maksimum_skor'] * $gr['indikator'] == 0 ? 0 : ($gr['skor'] / ($gr['maksimum_skor'] * $gr['indikator'])) * 100, 2) }}% --}}
                                {{ round($gr['indikator'] == 0 ? 0 : $gr['skor'] / $gr['indikator'], 1) }}
                            </button>
                            <button style="min-width:100px;"
                                class="btn btn-outline-dark">{{ $gr['skor'] }}/{{ $gr['maksimum_skor'] * $gr['indikator'] }}</button>
                            <button style="min-width:80px;" class="btn btn-outline-dark" data-bs-toggle="tooltip"
                                title="Lihat Indikator Belum Terjawab">
                                {{ $gr['filled'] }} / {{ $gr['indikator'] }}
                            </button>

                        </div>
                    </div>
                @endforeach

            </div>
        </div>

    </div>
</div>


{{-- @push('scripts')
    <script src="{{ asset('js/apexcharts.min.js') }}"></script>
@endpush --}}

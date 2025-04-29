<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-2" style="flex-wrap: wrap; overflow-x: auto;">
            <li class="breadcrumb-item">
                <a href="#">Akreditasi</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('admin.akreditasi.daftar')}}">Berkas {{ \App\Models\Berkas::findOrFail($berkas_id)->name }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('admin.akreditasi.komponen', ['id' => $berkas_id, 'role_id' => -1])}}">Komponen {{ \App\Models\Komponen::findOrFail($komponen_id)->name }}</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{route('admin.akreditasi.aspek',['berkas_id' => $berkas_id, 'komponen_id' => $komponen_id])}}">Aspek {{ \App\Models\Aspek::findOrFail($aspek_id)->name }}</a>
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

        <div class="p-4 overflow-auto border-2">
            @if ($aspek->isNotEmpty())
                <table class="table">
                    <thead>
                        <tr>
                            <th class="d-flex justify-content-center align-items-center" align="center">No</th>
                            <th>Indikator</th>
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
                                        <div class="border border-dark text-dark rounded-2 rounded-end-0 p-2 h-100"
                                            style="max-width: 500px; width: 100%; border-end-start-radius: 0;">
                                            {{ $k->name }}
                                        </div>
                                        <div class="cursor-pointer border border-dark h-100 bg-dark p-2 px-3 rounded-2 rounded-start-0"
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
    </div>

</div>

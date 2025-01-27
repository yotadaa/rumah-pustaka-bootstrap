@extends('admin.template.index')

@section('main')
    <div class="card border ">
        <div class="card-body ">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <label class="text-2xl font-bold gk-text-base-black mb-2">Daftar Komponen</label>
                <button class="btn text-black gk-bg-neutrals100 border-1 justify-content-center d-flex align-items-center gap-1 p-0 px-2" style="border-color: var(--primary);" href="#">
                    {{-- <i class="bi bi-plus gk-bg-base-black rounded-pill p-0 text-white" style="font-size: 20px; width: 29px; height: 29px;"></i> --}}
                    <i class="bi bi-plus p-0" style="font-size: 24px; font-weight: bold;"></i>
                    Tambah Komponen
                </button>
            </div>
            <hr></hr>
        </div>
        
    </div>
@endsection

@section('js')
    {{-- <script src="{{asset('modernize/libs/apexcharts/dist/apexcharts.min.js')}}"></script> --}}
@endsection

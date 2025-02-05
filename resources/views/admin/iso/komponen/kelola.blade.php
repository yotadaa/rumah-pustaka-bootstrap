@extends('admin.template.index')

@section('main')
@livewire('iso.komponen.kelola', ['berkasId' => $berkasId, 'komponenId' => $komponenId, 'role_id' => $role_id])
@endsection

@section('js')
{{-- <script src="{{asset('modernize/libs/apexcharts/dist/apexcharts.min.js')}}"></script> --}}
@endsection

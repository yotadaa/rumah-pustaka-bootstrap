@extends('admin.template.index')


@section('css')
<style>
    .table tbody tr:nth-child(odd) {
    background-color: #f8f9fa; /* Light gray for odd rows */
}

.table tbody tr:nth-child(even) {
    background-color: #ffffff; /* White for even rows */
}

.table th {
    font-weight: 600;
}

</style>
@endsection
@section('main')
@livewire('iso.divisi', ['id' => $id])
@endsection

@section('js')
{{-- <script src="{{asset('modernize/libs/apexcharts/dist/apexcharts.min.js')}}"></script> --}}
@endsection

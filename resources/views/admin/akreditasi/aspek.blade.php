@extends('admin.template.index')

@section('main')
    @livewire('akreditasi.aspek', ['berkas_id'=> $berkas_id, 'komponen_id' => $komponen_id] )
@endsection

@section('js')
@endsection

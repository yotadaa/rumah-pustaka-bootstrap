@extends('admin.template.index')

@section('main')
    @livewire('akreditasi.indikator', ['berkas_id' => $berkas_id, 'komponen_id' => $komponen_id, 'aspek_id' => $aspek_id])
@endsection

@section('js')
@endsection

@extends('admin.template.index')

@section('main')
    @livewire('akreditasi.sub-aspek', ['berkas_id' => $berkas_id, 'komponen_id' => $komponen_id, 'aspek_id' => $aspek_id])
@endsection

@section('js')
@endsection

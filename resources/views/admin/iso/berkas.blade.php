@extends('admin.template.index')

@section('main')
    @livewire('iso.berkas', ['type' => $type])
@endsection

@section('js')
@endsection

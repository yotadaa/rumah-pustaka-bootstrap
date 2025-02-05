@extends('admin.template.index')

@section('css')

<!-- Bootstrap JS (for dropdown functionality) -->
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}

<style>
    /* Ensure the dropdown menu is not constrained by the parent height */
    .dropdown-menu {
        max-height: 500px;
        /* Set a max height for the dropdown */
        overflow-y: auto;
        /* Enable vertical scrolling */
        position: absolute;
        /* Ensure the dropdown is positioned absolutely */
        z-index: 1000;
        /* Ensure the dropdown appears above other elements */
        top: 100%;
        /* Position the dropdown below the button */
        left: 0;
        /* Align the dropdown with the button */
        width: 100%;
        /* Match the width of the parent */
    }

    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        /* Responsive grid */
        gap: 16px;
        /* Space between grid items */
    }

    .grid-item {
        border: 1px solid #ddd;
        padding: 16px;
        border-radius: 8px;
        background: #fff;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .button-container {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .hidden {
        height: 0;
        overflow: hidden;
        transition: height 0.3s ease-in-out;
    }

    .button-container-list {
        display: none;
    }

    .item:hover .button-container-list {
        display: flex;
    }
</style>
@endsection

@section('main')
@livewire('iso.komponen', ['id' => $id, 'role_id' => $role_id])
@endsection

@section('js')
@endsection

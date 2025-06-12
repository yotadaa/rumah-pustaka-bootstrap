@extends('admin.template.index')

@section('css')
    <style>
        /* Variabel Warna untuk kemudahan kustomisasi */
        :root {
            --primary-blue: #0d6efd;
            --light-blue-bg: #e7f1ff;
            --light-grey-bg: #e9ecef;
            --dark-text: #212529;
            --grey-text: #6c757d;
        }

        /* Progress Bar Melingkar */
        .progress-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: conic-gradient(var(--primary-blue) 360deg, var(--light-grey-bg) 0deg);
            /* 360deg = 100% */
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-blue);
        }

        /* Kotak Angka pada Kartu Skor Tertinggi */
        .component-number {
            width: 45px;
            height: 45px;
            background-color: var(--light-blue-bg);
            border-radius: 0.5rem;
            display: grid;
            place-items: center;
            font-size: 1.25rem;
            font-weight: bold;
            color: var(--primary-blue);
            flex-shrink: 0;
        }

        /* Styling untuk setiap item komponen dalam daftar */
        .component-item {
            background-color: #e9ecef;
            /* Warna latar belakang abu-abu */
            border-radius: 0.5rem;
            margin-bottom: 0.75rem;
            overflow: hidden;
            /* Penting untuk rounded corners pada progress bar */
            position: relative;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .component-progress {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background-color: var(--light-blue-bg);
            border-radius: 0.5rem;
            z-index: 1;
        }

        .component-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.5rem;
            color: var(--dark-text);
        }

        .component-details {
            color: var(--grey-text);
            font-size: 0.9rem;
            flex-grow: 1;
            text-align: right;
            margin-right: 2rem;
        }

        /* Membuat Checkbox lebih besar dan tebal */
        .component-item .form-check-input {
            width: 1.8em;
            height: 1.8em;
            border: 2px solid var(--grey-text);
        }

        .component-item .form-check-input:checked {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        /* Penyesuaian untuk layar kecil (mobile) */
        @media (max-width: 768px) {
            .component-content {
                flex-direction: column;
                align-items: flex-start;
                padding: 1rem;
            }

            .component-details {
                text-align: left;
                margin-top: 0.5rem;
                margin-bottom: 0.5rem;
            }
        }
    </style>
@endsection

@section('main')
    @livewire('admin.dashboard')
@endsection

@section('js')
    <script src="{{ asset('modernize/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
@endsection

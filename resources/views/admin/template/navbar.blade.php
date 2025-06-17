@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Custom Styles */
        body {
            background-color: #f8f9fa;
            /* A light grey background */
        }

        .main-header {
            padding: 1.5rem;
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
        }

        .stat-card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        .stat-card .card-body {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-card-icon {
            font-size: 2rem;
            color: #0d6efd;
            /* Bootstrap primary blue */
        }

        .stat-card-info h3 {
            font-size: 1.75rem;
            font-weight: 700;
        }

        .stat-card-info p {
            font-size: 0.9rem;
            color: #6c757d;
            /* Bootstrap secondary text color */
            margin-bottom: 0;
        }

        .stat-card-growth {
            color: #198754;
            /* Bootstrap success green */
            font-weight: 600;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }
    </style>
@endpush

<header class="app-header py-0" style="">
    <nav class="navbar navbar-expand-lg navbar-light py-0">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>

                </a>

            </li>
        </ul>
        <header class="main-header w-100 d-flex justify-content-between align-items-center">
            <div>
            </div>


            <div class="d-flex align-items-center gap-3">
                <button type="button" class="btn btn-light position-relative">
                    <i class="bi bi-bell fs-5"></i>
                </button>
                <button type="button" class="btn btn-light position-relative">
                    <i class="bi bi-envelope fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        4
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </button>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-flag fs-5 me-2"></i>
                        <span>{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><span>{{ auth()->user()->name }}</span></a></li>
                    </ul>
                </div>
                <img src="https://i.pravatar.cc/40" alt="User Avatar" class="user-avatar rounded-circle">
            </div>
        </header>
    </nav>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}
</header>


@push('scripts')
@endpush

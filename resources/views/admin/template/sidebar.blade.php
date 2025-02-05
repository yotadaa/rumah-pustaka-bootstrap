@php
    $menuList = [
        [
            'title' => 'Master',
            'list' => [
                [
                    'title' => 'Dashboard',
                    'icon' => 'fas fa-home-alt',
                    'rute' => route('admin.dashboard'),
                    'type' => 'single',
                    'iconType' => 'fa',
                    'routeList' => '',
                ],
            ],
        ],
        [
            'title' => 'Akreditasi',
            'list' => [
                [
                    'title' => 'Berkas',
                    'icon' => 'fa fa-file-alt',
                    'rute' => '#',
                    'type' => 'single',
                    'iconType' => 'fa',
                    'routeList' => '',
                ],
            ],
        ],
        [
            'title' => 'ISO',
            'list' => [
                [
                    'title' => 'Berkas',
                    'icon' => 'fa fa-file-alt',
                    'rute' => route('admin.iso.daftar'),
                    'type' => 'single',
                    'iconType' => 'fa',
                    'routeList' => 'admin/iso',
                ],
            ],
        ],
        [
            'title' => 'Arsip',
            'list' => [
                [
                    'title' => 'Dashboard',
                    'icon' => 'fa   fa-archive',
                    'rute' => '#',
                    'type' => 'single',
                    'iconType' => 'fa',
                    'routeList' => '',
                ],
            ],
        ],
        [
            'title' => 'Akun',
            'list' => [
                [
                    'title' => 'Tambah Akun',
                    'icon' => 'fa fa-user-plus',
                    'rute' => route('register'),
                    'type' => 'single',
                    'iconType' => 'fa',
                    'routeList' => '',
                ],
            ],
        ],
    ];
@endphp

<aside class="left-sidebar " style="background-color: none;">
    <!-- Sidebar scroll-->
    <script>
        const currentRoute = (window.location.pathname + window.location.search).split("/").slice(1,3).join("/");
        console.log(currentRoute)
    </script>
    <div class="">
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="#" class="p-2 text-nowrap logo-img">
                <img src="{{ asset('logo.png') }}" class="w-100" width="" alt="" />
            </a>
            <div class="cursor-pointer close-btn d-xl-none d-block sidebartoggler" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="px-0 sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav" class="px-0 ps-2">
                @foreach ($menuList as $index => $menu)
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">{{ $menu['title'] }}</span>
                    </li>
                    @foreach ($menu['list'] as $submenu)
                        @if ($submenu['type'] == 'single')
                            <li class="sidebar-item rounded-0 w-100" style="">
                                <a id="menu-{{ $index }}"
                                    class="py-1 sidebar-link rounded-0 rounded-start-pill align-items-center"
                                    href="{{ $submenu['rute'] }}" aria-expanded="false" data-link = "{{$submenu['routeList']}}">
                                    @if ($submenu['iconType'] == 'img')
                                        <img src="{{ $submenu['icon'] }}"></img>
                                    @elseif ($submenu['iconType'] == 'fa')
                                        <i class="{{ $submenu['icon'] }}"></i>
                                    @endif
                                    <span class="hide-menu">{{ $submenu['title'] }}</span>
                                </a>
                            </li>
                            <script>
                                var itemMenu = document.getElementById('menu-{{$index}}');
                                var link = itemMenu.getAttribute('data-link');
                                if (currentRoute == link) {
                                    itemMenu.classList.add('active');
                                }

                            </script>
                        @endif
                    @endforeach
                @endforeach
                <li class="pe-2">
                    <form action="{{ route('admin.logout') }}" method="post">
                        @csrf
                        <button class="mt-2 btn btn-danger btn-block w-100">Log Out</button>
                    </form>

                </li>
            </ul>

        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>

<script>
    const menuList = document.querySelectorAll('.sidebar-link');

    // menuList.forEach(el => {
    //     if (el.href === window.location.href) {
    //         el.href = "#";
    //     }
    // });
</script>

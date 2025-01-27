@php
    $menuList = [
        [
            'title' => 'Master',
            'list' => [
                [
                    'title' => 'Dashboard',
                    'icon' => asset('heroicons/Icon/Solid/homehero.svg'),
                    'rute' => route('admin.dashboard'),
                    'type' => 'single',
                ],
            ],
        ],
        [
            'title' => 'Akreditasi',
            'list' => [
                [
                    'title' => 'Dashboard',
                    'icon' => asset('heroicons/Icon/Solid/homehero.svg'),
                    'rute' => '#',
                    'type' => 'single',
                ],
            ],
        ],
        [
            'title' => 'ISO',
            'list' => [
                [
                    'title' => 'Kelola',
                    'icon' => asset('heroicons/Icon/Outline/document-texthero.svg'),
                    'rute' => route('admin.iso.daftar'),
                    'type' => 'single',
                ],
            ],
        ],
        [
            'title' => 'Arsip',
            'list' => [
                [
                    'title' => 'Dashboard',
                    'icon' => asset('heroicons/Icon/Solid/homehero.svg'),
                    'rute' => '#',
                    'type' => 'single',
                ],
            ],
        ],
    ];
@endphp

<aside class="left-sidebar " style="background-color: none;">
    <!-- Sidebar scroll-->
    <div class="">
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="#" class="text-nowrap logo-img p-2">
                <img src="{{ asset('logo.png') }}" class="w-100" width="" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar px-0" data-simplebar="">
            <ul id="sidebarnav" class="px-0 ps-2">
                @foreach ($menuList as $menu)
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">{{ $menu['title'] }}</span>
                    </li>
                    @foreach ($menu['list'] as $submenu)
                        @if ($submenu['type'] == 'single')
                            <li class="sidebar-item rounded-0 w-100 " style="">
                                <a class="sidebar-link rounded-0 rounded-start-pill py-1 align-items-center" href="{{$submenu['rute']}}" aria-expanded="false">
                                    <span>
                                        <img src="{{ $submenu['icon'] }}"></img>
                                    </span>
                                    <span class="hide-menu">{{ $submenu['title'] }}</span>
                                </a>
                            </li>
                          @endif
                    @endforeach
                @endforeach
            </ul>

        </nav>
        <!-- End Sidebar navigation -->
    </div>


    <!-- End Sidebar scroll-->
</aside>

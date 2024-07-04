<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
            aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand font-weight-bold pt-0" href="{{ route('home') }}">
            <img src="{{ asset('img') }}/logo-hdn.png" class="navbar-brand-img" alt="...">
            &nbsp; AssetsHub
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1-800x800.jpg">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>{{ __('Settings') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>{{ __('Activity') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>{{ __('Support') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item"
                        onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                            data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                            aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="/dashboard">
                        <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }}
                    </a>
                </li>
                @if (auth()->user()->role == 'karyawan')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('my-asset') ? 'active' : '' }}" href="/my-asset">
                            <i class="ni ni-bag-17 text-warning"></i> {{ __('My Asset') }}
                        </a>
                    </li>
                @endif
                @if (auth()->user()->role == 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('administrator') ? 'active' : '' }}" href="/administrator">
                            <i class="ni ni-single-02 text-info"></i> {{ __('Administrator') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('karyawan') ? 'active' : '' }}" href="/karyawan">
                            <i class="ni ni-badge text-warning"></i> {{ __('Karyawan') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('product-category') ? 'active' : '' }}"
                            href="/product-category">
                            <i class="ni ni-bullet-list-67 text-default"></i> {{ __('Kategori Asset') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('pengajuan') ? 'active' : '' }}" href="/pengajuan">
                            <i class="ni ni-paper-diploma text-yellow"></i> {{ __('Pengajuan Pinjam') }}
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('product') ? 'active' : '' }}" href="/product">
                        <i class="ni ni-collection text-info"></i> {{ __('Asset') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('transaction') ? 'active' : '' }}" href="/transaction">
                        <i class="ni ni-planet text-success"></i> {{ __('Transaksi') }}
                    </a>
                </li>

            </ul>
            <!-- Divider -->
            <hr class="my-3">
            <!-- Heading -->
            <h6 class="navbar-heading text-muted">Laporan</h6>
            <!-- Navigation -->

            <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                    <a class="nav-link" href="/laporan-absensi">
                        <i class="ni ni-book-bookmark"></i>Laporan Transaksi
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="/laporan-penggajian">
                        <i class="ni ni-money-coins"></i>Laporan Penggajian
                    </a>
                </li> --}}
            </ul>
        </div>
    </div>
</nav>

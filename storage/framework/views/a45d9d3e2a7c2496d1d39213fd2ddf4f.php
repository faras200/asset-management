<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
            aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand font-weight-bold pt-0" href="<?php echo e(route('home')); ?>">
            <img src="<?php echo e(asset('img')); ?>/logo-hdn.png" class="navbar-brand-img" alt="...">
            &nbsp; AssetsHub
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="<?php echo e(asset('argon')); ?>/img/theme/team-1-800x800.jpg">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0"><?php echo e(__('Welcome!')); ?></h6>
                    </div>
                    <a href="<?php echo e(route('profile.edit')); ?>" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span><?php echo e(__('My profile')); ?></span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span><?php echo e(__('Settings')); ?></span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span><?php echo e(__('Activity')); ?></span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span><?php echo e(__('Support')); ?></span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="<?php echo e(route('logout')); ?>" class="dropdown-item"
                        onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span><?php echo e(__('Logout')); ?></span>
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
                        <a href="<?php echo e(route('home')); ?>">
                            <img src="<?php echo e(asset('argon')); ?>/img/brand/blue.png">
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
                <li class="nav-item <?php echo e(Request::is('dashboard') ? 'active' : ''); ?>">
                    <a class="nav-link" href="/dashboard">
                        <i class="ni ni-tv-2 text-primary"></i> <?php echo e(__('Dashboard')); ?>

                    </a>
                </li>
                
                <li class="nav-item <?php echo e(Request::is('karyawan') ? 'active' : ''); ?>"">
                    <a class="nav-link" href="/karyawan">
                        <i class="ni ni-badge text-warning"></i> <?php echo e(__('Karyawan')); ?>

                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/product-category">
                        <i class="ni ni-settings-gear-65 text-default"></i> <?php echo e(__('Kategori Asset')); ?>

                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/product">
                        <i class="ni ni-collection text-info"></i> <?php echo e(__('Asset')); ?>

                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/transaction">
                        <i class="ni ni-planet text-success"></i> <?php echo e(__('Transaksi')); ?>

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
                
            </ul>
        </div>
    </div>
</nav>
<?php /**PATH /Users/andysuryawan/Documents/warungkoki/asset-management/resources/views/layouts/navbars/sidebar.blade.php ENDPATH**/ ?>
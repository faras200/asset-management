<?php $__env->startSection('content'); ?>
    
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
        <div class="container-fluid">
            <div class="header-body">
                <!-- Card stats -->
                <div class="row">
                    <div class="col-xl-4 col-lg-4">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Total Asset</h5>
                                        <span class="h2 font-weight-bold mb-0"><?php echo e($assets->count()); ?></span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                            <i class="fas fa-chart-bar"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-nowrap">Total Data</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Harga Asset</h5>
                                        <span
                                            class="h2 font-weight-bold mb-0"><?php echo e('Rp ' . number_format($assets->sum('price'), 0, ',', '.')); ?></span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                            <i class="fas fa-chart-pie"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-nowrap">Total Data</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Karyawan</h5>
                                        <span class="h2 font-weight-bold mb-0"><?php echo e($karyawans->count()); ?></span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-nowrap">Total Data</span>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    
    <div class="container-fluid mt--8">

        <div class="row mt-5">
            <div class="col-xl-8 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Transaksi hari ini</h3>
                            </div>
                            <div class="col text-right">
                                <a href="/transaction" class="btn btn-sm btn-primary">See all</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Uuid</th>
                                    <th scope="col">Nama Karyawan</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($transactions->where('date', date('Y-m-d'))->isEmpty()): ?>
                                    <th scope="row" colspan="4" class="text-center">
                                        Data Tidak Ada
                                    </th>
                                <?php endif; ?>
                                <?php $__currentLoopData = $transactions->where('date', date('Y-m-d')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $absen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo e($absen->uuid); ?>

                                        </th>
                                        <th>
                                            <?php echo e($absen->karyawan); ?>

                                        </th>
                                        <td>
                                            <?php echo e($absen->type); ?>

                                        </td>
                                        <td>
                                            <?php echo e($absen->date); ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Karyawan</h3>
                            </div>
                            <div class="col text-right">
                                <a href="/karyawan" class="btn btn-sm btn-primary">See all</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Kode</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $karyawans->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $karyawan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo e($karyawan->name); ?>

                                        </th>
                                        <td>
                                            <?php echo e($karyawan->code); ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <script src="<?php echo e(asset('argon')); ?>/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="<?php echo e(asset('argon')); ?>/vendor/chart.js/dist/Chart.extension.js"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/andysuryawan/Documents/warungkoki/asset-management/resources/views/dashboard.blade.php ENDPATH**/ ?>
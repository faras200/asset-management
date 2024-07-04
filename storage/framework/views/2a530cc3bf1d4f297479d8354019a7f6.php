<?php $__env->startSection('content'); ?>
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
        <div class="container-fluid pb-6 pb-xl-6">
            <div class="header-body">
            </div>
        </div>
    </div>
    <div class="container-fluid mt--8 pt--4">
        <div class="row">
            <div class="col-xl-12 mb-5 mt--6 mt-xl--6 mb-xl-0">
                <div class="card bg-gradient-white shadow">
                    <!-- Card header -->
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6>
                                <h2 class=" mb-0">Tambah Transaksi</h2>
                            </div>
                            <div class="col">

                            </div>
                        </div>
                    </div>
                    <!-- Light table -->
                    <div class="card-body">
                        <form method="post" action="/transaction">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="status">Pilih Tipe Transaksi</label>
                                        <select id="type" name="type" required class="form-control"
                                            aria-label="With textarea" value="<?php echo e(old('type')); ?>">
                                            <option value="" selected disabled>Pilih</option>
                                            <?php if(auth()->user()->role == 'admin'): ?>
                                                <option value="pembelian">Pembelian</option>
                                            <?php endif; ?>
                                            <option value="dipakai">Di Pakai</option>
                                            
                                            <option value="dikembalikan">Di Kembalikan</option>
                                        </select>
                                        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-danger"> <?php echo e($message); ?> </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                            </div>

                            <div id="dynamicInput" class="row">

                            </div>

                            <div id="addmore" class="row">

                            </div>
                            <hr>
                            <div class="col-12">
                                <div class="text-right">
                                    <button type="submit" name="submit" class="btn btn-default">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript">
        $(document).ready(function() {
            var categories = <?php echo e(Js::from($category)); ?>

            var users = <?php echo e(Js::from($users)); ?>

            var assets = <?php echo e(Js::from($assets)); ?>

            var i = 0;
            console.log(categories);
            $('#type').on('change', function() {
                i = 0;
                var selectedType = $(this).val();
                console.log(selectedType);
                var inputHtml = '';

                if (selectedType === 'pembelian') {
                    inputHtml = htmlPembelian(i);
                    $(document).ready(function() {
                        $('.use-select2').select2({
                            theme: "bootstrap4"
                        });

                    });
                } else if (selectedType === 'dipakai') {
                    inputHtml = htmldipakai(i);
                    $(document).ready(function() {
                        $('.use-select2').select2({
                            theme: "bootstrap4"
                        });
                        $('#asset-select2-' + i).select2({
                            theme: "bootstrap4"
                        });
                    });
                } else if (selectedType === 'dikembalikan') {
                    inputHtml = htmldikembalikan(i);
                    $(document).ready(function() {
                        $('.use-select2').select2({
                            theme: "bootstrap4"
                        });
                        $('#asset-select2-' + i).select2({
                            theme: "bootstrap4"
                        });
                    });
                }

                $('#dynamicInput').html(inputHtml);


            });


            $(document).on('click', '#add', function() {
                ++i;
                $('#dynamicTable').append(htmlProduct(i));
            });

            $(document).on('click', '#addAssetDipakai', function() {
                ++i;
                $('#dynamicTable').append(htmlAsset(i, 'dipakai'));

                $('#asset-select2-' + i).select2({
                    theme: "bootstrap4"
                });

            });
            $(document).on('click', '#addAssetDikembalikan', function() {
                ++i;
                $('#dynamicTable').append(htmlAsset(i, 'dikembalikan'));

                $('#asset-select2-' + i).select2({
                    theme: "bootstrap4"
                });

            });

            function htmlPembelian(i) {
                return `
                 <?php if(auth()->user()->role == 'admin'): ?>
                <div class="col-lg-6">
                    <div class="form-group">
                <label for="user">Karyawan Pembeli</label>
                      <select id="name" required name="user" class="form-control use-select2"
                        aria-label="With textarea" value="<?php echo e(old('type')); ?>">
                        <option value="" selected disabled>Pilih</option>` +
                    users.map(function(user) {
                        return `<option value="${user.id}">${user.name}</option>`
                    }).join('') +
                    `</select>
                    </div>
                    </div>
                    <?php endif; ?>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="date">Tanggal Beli</label>
                <input type="date" name="date" class="form-control" id="date" required>
                <div class="text-danger" style="display:none;" id="error-name"> <!-- Placeholder for error message --> </div>
              </div>
            </div>
                <div class="col-12">
                <h4>Data Produk</h4>
                <table class="table table-bordered" id="dynamicTable">  

            <tr>

                <th>Name</th>

                <th>Category</th>

                <th>Serial Number</th>

                <th>Harga</th>

                <th>Action</th>

            </tr>

            <tr>  

                <td> <input type="text" name="products[` + i + `][name]" class="form-control" id="name" placeholder="Nama Asset" required></td>  

                <td> <select id="category" name="products[` + i + `][category]" class="form-control"
                        aria-label="With textarea" value="<?php echo e(old('type')); ?>">
                        <option value="" selected disabled>Pilih</option>` +
                    categories.map(function(category) {
                        return `<option value="${category.id}">${category.name}</option>`
                    }).join('') +
                    `</select></td>  

                <td><input type="text" name="products[` + i + `][sn]" class="form-control" id="sn" placeholder="Serial Number" required value="<?php echo e(old('sn')); ?>"></td>  

                <td><input type="text" name="products[` + i + `][price]" class="form-control" id="price" placeholder="Harga" required value="<?php echo e(old('price')); ?>"></td>  

                <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>  

            </tr>  

        </table> 
            </div>
            `;
            }

            function htmlProduct(i) {
                return `
                <tr>  

                <td> <input type="text" name="products[` + i + `][name]" class="form-control" id="name" placeholder="Nama Asset" required></td>  

                <td> <select id="category" name="products[` + i + `][category]" class="form-control"
                        aria-label="With textarea" value="<?php echo e(old('type')); ?>">
                        <option value="" selected disabled>Pilih</option>` +
                    categories.map(function(category) {
                        return `<option value="${category.id}">${category.name}</option>`
                    }).join('') +
                    `</select></td>  

                <td><input type="text" name="products[` + i + `][sn]" class="form-control" id="sn" placeholder="Kode Asset" required value="<?php echo e(old('sn')); ?>"></td>  

                <td><input type="text" name="products[` + i + `][price]" class="form-control" id="price" placeholder="Harga" required value="<?php echo e(old('price')); ?>"></td>  

                <td><button type="button" class="btn btn-danger remove-tr">Remove</button></td>  

            </tr>  
                `
            }

            function htmldipakai(i) {
                return `
                 <?php if(auth()->user()->role == 'admin'): ?>
                <div class="col-lg-6">
                    <div class="form-group">
                <label for="user">Karyawan Peminjam</label>
                      <select id="name" name="user" required class="form-control use-select2"
                        aria-label="With textarea" value="<?php echo e(old('type')); ?>">
                        <option value="" selected disabled>Pilih</option>` +
                    users.map(function(user) {
                        return `<option value="${user.id}">${user.name}</option>`
                    }).join('') +
                    `</select>
                    </div>
                    </div>
                    <?php endif; ?>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="date">Tanggal Pinjam</label>
                <input type="date" name="date" class="form-control" id="date" required>
                <div class="text-danger" style="display:none;" id="error-name"> <!-- Placeholder for error message --> </div>
              </div>
            </div>
                <div class="col-12">
                <h4>Data Assets</h4>
                <table class="table table-bordered" id="dynamicTable">  

            <tr>

                <th width="10%">No</th>

                <th>Asset</th>

                <th width="20%">Action</th>

            </tr>

            <tr>  
                <td>` + (i + 1) + `</td>

                <td> <select style="width: 100%" id="asset-select2-` + i + `" name="products[` + i + `][asset]" class="form-control"
                         value="<?php echo e(old('type')); ?>">
                        <option value="" selected disabled>Pilih Asset</option>` +
                    assets.filter(function(asset) {
                        return asset.status === 'available'; // Change 'available' to the desired status
                    }).map(function(asset) {
                        return `<option value="${asset.id}">${asset.name} (${asset.serial_number}) (${asset.status})</option>`;
                    }).join('') +
                    `</select></td>  

                <td><button type="button" name="add" id="addAssetDipakai" class="btn btn-success">Add More</button></td>  

            </tr>  

        </table> 
            </div>
            `;
            }

            function htmlAsset(i, tipe) {
                return `
                <tr>  
                <td>` + (i + 1) + `</td>

                <td> <select style="width: 100%" id="asset-select2-` + i + `" name="products[` + i + `][asset]" class="form-control"
                        value="<?php echo e(old('type')); ?>">
                        <option value="" selected disabled>Pilih</option>` +
                    assets.filter(function(asset) {
                        return tipe == 'dipakai' ? asset.status === 'available' : tipe == 'dikembalikan' ? asset
                            .status ===
                            'in_use' : asset.status != null; // Change 'available' to the desired status
                    }).map(function(asset) {
                        return `<option value="${asset.id}">${asset.name} (${asset.serial_number}) (${asset.status})</option>`;
                    }).join('') +
                    `</select></td>  

                <td><button type="button" class="btn btn-danger remove-tr">Remove</button></td>  

            </tr>  
                `
            }

            function htmldikembalikan(i) {
                return `
                 <?php if(auth()->user()->role == 'admin'): ?>
                <div class="col-lg-6">
                    <div class="form-group">
                <label for="user">Karyawan Pengembalian</label>
                      <select required id="name" name="user" class="form-control use-select2"
                        aria-label="With textarea" value="<?php echo e(old('type')); ?>">
                        <option value="" selected disabled>Pilih</option>` +
                    users.map(function(user) {
                        return `<option value="${user.id}">${user.name}</option>`
                    }).join('') +
                    `</select>
                    </div>
                    </div>
                    <?php endif; ?>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="date">Tanggal Pengembalian</label>
                <input type="date" name="date" class="form-control" id="date" required>
                <div class="text-danger" style="display:none;" id="error-name"> <!-- Placeholder for error message --> </div>
              </div>
            </div>
                <div class="col-12">
                <h4>Data Assets</h4>
                <table class="table table-bordered" id="dynamicTable">  

            <tr>

                <th width="10%">No</th>

                <th>Asset</th>

                <th width="20%">Action</th>

            </tr>

            <tr>  
                <td>` + (i + 1) + `</td>

                <td> <select style="width: 100%" id="asset-select2-` + i + `" name="products[` + i + `][asset]" class="form-control"
                         value="<?php echo e(old('type')); ?>">
                        <option value="" selected disabled>Pilih Asset</option>` +
                    assets.filter(function(asset) {
                        return asset.status === 'in_use'; // Change 'available' to the desired status
                    }).map(function(asset) {
                        return `<option value="${asset.id}">${asset.name} (${asset.serial_number}) (${asset.status})</option>`;
                    }).join('') +
                    `</select></td>  

                <td><button type="button" name="add" id="addAssetDikembalikan" class="btn btn-success">Add More</button></td>  

            </tr>  

        </table> 
            </div>
            `;
            }

            $(document).on('click', '.remove-tr', function() {
                $(this).parents('tr').remove();
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/andysuryawan/Documents/warungkoki/asset-management/resources/views/transaction/create.blade.php ENDPATH**/ ?>
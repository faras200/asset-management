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
                <?php if(session()->has('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                        <span class="alert-inner--text"><strong>Success!</strong> <?php echo e(session('success')); ?></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <div class="card bg-gradient-white shadow">
                    <!-- Card header -->
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-light ls-1 mb-1">Master Data</h6>
                                <h2 class=" mb-0">Assets</h2>
                            </div>
                            <div class="col">
                                <ul class="nav nav-pills justify-content-end">
                                    <li class="nav-item mr-2 mr-md-0" data-toggle="chart" data-target="#chart-sales"
                                        data-update='{"data":{"datasets":[{"data":[0, 20, 10, 30, 15, 40, 20, 60, 60]}]}}'
                                        data-prefix="$" data-suffix="k">
                                        
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Light table -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tbl_list"
                                class="table align-items-center table-flush table-bordered dt-responsive nowrap"
                                width="100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">SN</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Dipakai Oleh</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" class="text-right">Aksi</th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="lihatnya" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <div class="col-6">
                        <h3 class="modal-title" id="modal-title-default">Detail Asset</h3>
                    </div>
                    <div class="col-6" align="right">
                        
                    </div>

                </div>

                <div class="modal-body" style="padding-bottom: 0px;padding-top: 0px;">
                    <div class="row">
                        <div class="col-12">
                            <label>Nama Asset</label>
                            <br>
                            <div style="font-size: 16px;" id="nama_asset"></div>
                            <br>
                            <label>Tanggal Pembelian</label>
                            <br>
                            <div style="font-size: 16px;" id="tanggal_beli"></div>
                            <br>

                            <label>Riwayat Transaksi</label>
                        </div>

                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table" width="100%">
                                    <tr>
                                        <th>No</th>
                                        <th>Uuid</th>
                                        <th>Karyawan</th>
                                        <th>Tipe</th>
                                        <th>Tanggal</th>
                                    </tr>
                                    <tbody id="contentnya">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer tombolnya2" style="display:none;">
                    <table width="100%">
                        <tr>
                            <td>
                                <button type="button" class="btn btn-secondary btn-block ml-auto"
                                    data-dismiss="modal">Tutup</button>
                            </td>
                            <td width="5%">
                                &nbsp;
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tbl_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: '<?php echo e(url()->current()); ?>',
                oLanguage: {
                    "sEmptyTable": "Belum ada data",
                    "sProcessing": "Sedang memproses...",
                    "sLengthMenu": "Tampilkan _MENU_ data",
                    "sZeroRecords": "Tidak ditemukan data yang sesuai",
                    "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                    "sInfoFiltered": "(disaring dari total _MAX_ data)",
                    "sSearch": "Cari:",
                    "oPaginate": {
                        "sFirst": "Pertama",
                        "sPrevious": "<",
                        "sNext": ">",
                        "sLast": "Terakhir"
                    }
                },
                lengthMenu: [
                    [25, 50, 100, 500, 1000, ],
                    [25, 50, 100, 500, 1000, ]
                ],

                pagingType: 'simple_numbers',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'serial_number',
                        name: 'serial_number'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'karyawan',
                        name: 'karyawan'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        render: function(data, type, row) {
                            return '<div style="text-align: right;">' +
                                //     '<a href="/product/' + row.id +
                                //     '/edit" class="btn btn-icon btn-primary btn-sm" type="button">' +
                                //     '<span class="btn-inner--icon"><i class="fas fa-edit text-white"></i></span></a> ' +
                                //     '<form class="d-inline" action="/product/' + row.id +
                                //     '" method="post" onsubmit="return confirmDelete(event)" style="display: inline;">' +
                                //     '<input type="hidden" name="_method" value="delete">' +
                                //     '<input type="hidden" name="_token" value="' + $(
                                //         'meta[name="csrf-token"]').attr('content') + '">' +
                                //     '<button type="submit" class="btn btn-icon btn-danger btn-sm">' +
                                //     '<span class="btn-inner--icon"><i class="fas fa-trash-alt"></i></span>' +
                                //     '</button></form>' +
                                '<button class="btn btn-success btn-sm" onclick="Lihat(' +
                                row.id + ')"><i class="fa fa-eye"></i></button></div>';
                        }

                    }

                ]
            });
        });

        function confirmDelete(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit(); // Submitting the form if confirmed
                }
            });
            return false;
        }

        function Lihat(id) {

            $('#lihatnya').modal('show');

            $.ajax({
                type: 'POST',
                url: "<?php echo e(route('product.show')); ?>",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': id,
                },
                success: function(response) {
                    var content_data = '';
                    var nama_asset = response.product.name;
                    var tanggalBeli = response.product.purchase_date;

                    if (response.transaction.length === 0) {
                        content_data =
                            '<tr ><td style="text-align: center;" colspan="5">No data available</td></tr>';
                    } else {
                        var no = 1;
                        $.each(response.transaction, function(index, data) {
                            content_data += '<tr>';
                            content_data += '<td>' + (no++) + '</td>';
                            content_data += '<td>' + data.uuid + '</td>';
                            content_data += '<td>' + data.karyawan + '</td>';
                            content_data += '<td>' + data.type + '</td>';
                            content_data += '<td>' + data.date + '</td>';
                            content_data += '</tr>';
                        });
                    }

                    $('#contentnya').html(content_data);
                    $('#nama_asset').html(nama_asset);
                    $('#tanggal_beli').html(tanggalBeli);

                }
            });

        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/andysuryawan/Documents/warungkoki/asset-management/resources/views/product/index.blade.php ENDPATH**/ ?>
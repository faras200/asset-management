@extends('layouts.app')

@section('content')
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
        <div class="container-fluid pb-6 pb-xl-6">
            <div class="header-body">
            </div>
        </div>
    </div>
    <div class="container-fluid mt--8 pt--4">
        <div class="row">
            <div class="col-xl-12 mb-5 mt--6 mt-xl--6 mb-xl-0">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                        <span class="alert-inner--text"><strong>Success!</strong> {{ session('success') }}</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card bg-gradient-white shadow">
                    <!-- Card header -->
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-light ls-1 mb-1">Master Data</h6>
                                <h2 class=" mb-0">Transaksi</h2>
                            </div>
                            <div class="col-lg-3 col-6">
                                <a href="/transaction/create" class="nav-link btn btn-primary py-2 px-3 active">
                                    <span class="">Tambah data <i class="ni ni-fat-add"></i></span>
                                </a>
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
                                        <th scope="col">Karyawan</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Type</th>
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
                        <h3 class="modal-title" id="modal-title-default">Detail Transaksi</h3>
                    </div>
                    <div class="col-6" align="right">
                        {{-- <button id="links" class="btn btn-success btn-sm"><i class="fa fa-print"></i>
                            &nbsp;Cetak</button> --}}
                    </div>

                </div>

                <div class="modal-body" style="padding-bottom: 0px;padding-top: 0px;">
                    <div class="row">
                        <div class="col-12">
                            <label>Nama Karyawan</label>
                            <br>
                            <div style="font-size: 16px;" id="nama_karyawan"></div>
                            <br>
                            <label>Tipe Transaksi</label>
                            <br>
                            <div style="font-size: 16px;" id="type"></div>
                            <br>
                            <label>Tanggal Transaksi</label>
                            <br>
                            <div style="font-size: 16px;" id="tanggal"></div>
                            <br>
                        </div>

                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table" width="100%">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Asset</th>
                                        <th>Serial Number</th>
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
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tbl_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}',
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
                        data: 'karyawan',
                        name: 'karyawan'
                    }, {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        render: function(data, type, row) {
                            return '<div style="text-align: right;">' +
                                '@if (Auth::user()->hasRole('Admin'))<form class="d-inline" action="/transaction/' +
                                row.id +
                                '" method="post" onsubmit="return confirmDelete(event)" style="display: inline;">' +
                                '<input type="hidden" name="_method" value="delete">' +
                                '<input type="hidden" name="_token" value="' + $(
                                    'meta[name="csrf-token"]').attr('content') + '">' +
                                '<button type="submit" class="btn btn-icon btn-danger btn-sm">' +
                                '<span class="btn-inner--icon"><i class="fas fa-trash-alt"></i></span>' +
                                '</button></form> @endif' +
                                '&nbsp;&nbsp;<button class="btn btn-success btn-sm" onclick="Lihat(' +
                                row
                                .id +
                                ')"><i class="fa fa-eye"></i></button></div>';
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
                url: "{{ route('transaction.show') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': id,
                },
                success: function(response) {
                    var content_data = '';
                    var nama_karyawan = response.transaction.karyawan;
                    var tanggal = response.transaction.date;
                    var type = response.transaction.type;
                    var id = response.transaction.id;
                    var no = 1;
                    $.each(response.transaction_details, function(index, data) {
                        content_data += '<tr>';
                        content_data += '<td>' + (no++) + '</td>';
                        content_data += '<td>' + data.asset + '</td>';
                        content_data += '<td>' + data.sn + '</td>';
                        content_data += '</tr>';
                    });

                    $('#contentnya').html(content_data);
                    $('#nama_karyawan').html(nama_karyawan);
                    $('#type').html(type);
                    $('#tanggal').html(tanggal);
                }
            });

        }

        function formatRupiah(angka) {
            angka = angka.toString()
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return rupiah ? "Rp. " + rupiah : "";
        }
    </script>
@endpush

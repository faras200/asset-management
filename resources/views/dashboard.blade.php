@extends('layouts.app')

@section('content')
    {{-- headers card --}}
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
                                        <span class="h2 font-weight-bold mb-0">{{ $assets->count() }}</span>
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
                                            class="h2 font-weight-bold mb-0">{{ 'Rp ' . number_format($assets->sum('price'), 0, ',', '.') }}</span>
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
                                        <span class="h2 font-weight-bold mb-0">{{ $karyawans->count() }}</span>
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

    {{-- content --}}
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
                                @if ($transactions->where('date', date('Y-m-d'))->isEmpty())
                                    <th scope="row" colspan="4" class="text-center">
                                        Data Tidak Ada
                                    </th>
                                @endif
                                @foreach ($transactions->where('date', date('Y-m-d')) as $absen)
                                    <tr>
                                        <th scope="row">
                                            {{ $absen->uuid }}
                                        </th>
                                        <th>
                                            {{ $absen->karyawan }}
                                        </th>
                                        <td>
                                            {{ $absen->type }}
                                        </td>
                                        <td>
                                            {{ $absen->date }}
                                        </td>
                                    </tr>
                                @endforeach
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
                                @foreach ($karyawans->take(10) as $karyawan)
                                    <tr>
                                        <th scope="row">
                                            {{ $karyawan->name }}
                                        </th>
                                        <td>
                                            {{ $karyawan->code }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush

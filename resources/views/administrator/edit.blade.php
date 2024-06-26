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
                <div class="card bg-gradient-white shadow">
                    <!-- Card header -->
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class=" mb-0">Ubah Data Admin</h2>
                            </div>
                            <div class="col">

                            </div>
                        </div>
                    </div>
                    <!-- Light table -->
                    <div class="card-body">
                        @foreach ($admins as $admin)
                            <form method="post" action="/administrator/{{ $admin->id }}">
                                @method('put')
                                @csrf

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" name="nama" class="form-control" id="nama"
                                                value="{{ old('nama', $admin->nama) }}">
                                            @error('nama')
                                                <div class="text-danger"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control" id="email"
                                                value="{{ old('email', $admin->email) }}">
                                            @error('email')
                                                <div class="text-danger"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="role">Pilih peran</label>
                                            <select id="role" name="role" class="form-control"
                                                aria-label="With textarea">
                                                <option selected value="{{ old('role', $admin->role) }}">{{ $admin->role }}
                                                </option>

                                                <option value="admin">Admin</option>
                                                <option value="pimpinan">Pimpinan</option>
                                            </select>
                                            @error('role')
                                                <div class="text-danger"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="id_finger">Password</label>
                                            <input type="password" name="password" class="form-control" id="password"
                                                placeholder="" value="{{ old('password') }}">
                                            <div class="text-sm"> Kosongkan apabila tidak diubah</div>
                                            @error('password')
                                                <div class="text-danger"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="col-12">
                                    <div class="text-right">
                                        <button type="submit" name="submit" class="btn btn-default">Ubah data</button>
                                    </div>
                                </div>
                        @endforeach
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

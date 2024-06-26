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
                                <h2 class=" mb-0">Ubah Data Kategori</h2>
                            </div>
                            <div class="col">

                            </div>
                        </div>
                    </div>
                    <!-- Light table -->
                    <div class="card-body">
                        <form method="post" action="/product-category/{{ $category->id }}">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name">Nama Kategori</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            value="{{ old('name', $category->name) }}">
                                        @error('name')
                                            <div class="text-danger"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="col-12">
                                <div class="text-right">
                                    <button type="submit" name="submit" class="btn btn-default">Ubah
                                        data</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

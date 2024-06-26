<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Penggajian;
use App\Models\StatusKaryawan;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = User::get();

            return Datatables::of($data)->addIndexColumn()->make(true);
        }

        return view('karyawan.index', [
            'karyawans' => Karyawan::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('karyawan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'name' => 'required|max:255',
            'code'  => 'required|unique:karyawan',
            'alamat'  => 'required:max:5000',
        ]);

        User::create($validasi);

        Penggajian::create(['karyawan_id' => User::latest()->first()->id,]);

        return redirect('/karyawan')->with('success', 'Berhasil Menambah Karyawan!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $karyawan)
    {
        return view('karyawan.edit', [
            'karyawan' => $karyawan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $karyawan)
    {
        $rules = [
            'name' => 'required|max:255',
            'alamat'  => 'required:max:5000',
        ];

        if ($request->code != $karyawan->code) {
            $rules['code'] = 'required|unique:user';
        }

        $validasi = $request->validate($rules);

        User::where('id', $karyawan->id)
            ->update($validasi);

        return redirect('/karyawan')->with('success', 'Berhasil Diubah!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();

        return redirect('/karyawan')->with('success', 'Berhasil Dihapus!!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Penggajian;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Product::select('products.*', 'product_categories.name as category')->leftJoin('product_categories', 'products.category_id', '=', 'product_categories.id')->get();

            return Datatables::of($data)->addIndexColumn()->make(true);
        }

        return view('product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
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

        return redirect('/product')->with('success', 'Berhasil Menambah Karyawan!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $transaction = Transaction::select('transactions.*', DB::raw('DATE_FORMAT(transactions.date, "%d-%m-%Y") as date'), 'users.name as karyawan', 'products.name as asset')->leftJoin('users', 'transactions.user_id', '=', 'users.id')->leftJoin('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')->leftJoin('products', 'transaction_details.product_id', '=', 'products.id')->where('transaction_details.product_id', $request->id)->get();

        // $transaction_details = TransactionDetail::select('transaction_details.*', 'products.name as asset', 'products.serial_number as sn')->leftJoin('products', 'transaction_details.product_id', '=', 'products.id')->where('transaction_details.transaction_id', $transaction->id)->get();

        return response()->json([
            'transaction' => $transaction,
            // 'transaction_details' => $transaction_details,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('product.edit', [
            'product' => $product,
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

        return redirect('/product')->with('success', 'Berhasil Diubah!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::where('id', $id)->delete();

        return redirect('/product')->with('success', 'Berhasil Dihapus!!');
    }
}

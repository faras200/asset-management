<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Karyawan;
use App\Models\Penggajian;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\TransactionDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($request->ajax()) {

            if ($user->role == 'karyawan') {
                $data = Transaction::select('transactions.*', 'users.name as karyawan')->leftJoin('users', 'transactions.user_id', '=', 'users.id')->where('transactions.user_id', $user->id)->orderBy('transactions.created_at', 'desc')->get();
            } else {
                $data = Transaction::select('transactions.*', 'users.name as karyawan')->leftJoin('users', 'transactions.user_id', '=', 'users.id')->orderBy('transactions.created_at', 'desc')->get();
            }

            return Datatables::of($data)->addIndexColumn()->make(true);
        }

        return view('transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('transaction.create', [
            'category' => ProductCategory::get(),
            'assets' => Product::get(),
            'users' => User::get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user()->role == 'karyawan' ? Auth::user()->id : $request->user;
        $date = $request->date;

        if ($request->type == 'pembelian') {
            foreach ($request->products as $key => $value) {
                $products[] = Product::create([
                    'name' => $value['name'],
                    'category_id' => $value['category'],
                    'price' => $value['price'],
                    'serial_number' => $value['sn'],
                    'status' => 'available',
                    'purchase_date' => $date,
                ]);
            }
        } elseif ($request->type == 'dipakai') {
            // return $request->products;
            foreach ($request->products as $value) {
                $product = Product::find($value['asset']);

                // Pastikan produk ditemukan sebelum mengupdate
                if ($product) {
                    $product->update([
                        'status' => Auth::user()->role == 'karyawan' ? 'available' : 'in_use',
                        'user_id' =>  Auth::user()->role == 'karyawan' ? null : $user
                    ]);

                    // Simpan produk ke dalam array
                    $products[] = $product;
                }
            }
        } elseif ($request->type == 'dikembalikan') {
            // return $request->products;
            foreach ($request->products as $value) {
                $product = Product::find($value['asset']);

                // Pastikan produk ditemukan sebelum mengupdate
                if ($product) {
                    $product->update([
                        'user_id' => null,
                        'status' => 'available',
                    ]);

                    // Simpan produk ke dalam array
                    $products[] = $product;
                }
            }
        }

        $transaction = Transaction::create([
            'uuid' => "TRX" .  date('Ymd') . rand(100, 9999),
            'user_id' => $user,
            'type' => $request->type,
            'status' => Auth::user()->role == 'karyawan' ? 'pengajuan' : 'approve',
            'date' => $date,
        ]);

        foreach ($products as $key => $value) {
            $transactiondetail = TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $value['id'],
                'quantity' => 1,
            ]);
        }

        return redirect('/transaction')->with('success', 'Berhasil Menambah Transaksi!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $transaction = Transaction::select('transactions.*', 'users.name as karyawan')->leftJoin('users', 'transactions.user_id', '=', 'users.id')->where('transactions.id', $request->id)->first();

        $transaction_details = TransactionDetail::select('transaction_details.*', 'products.name as asset', 'products.serial_number as sn')->leftJoin('products', 'transaction_details.product_id', '=', 'products.id')->where('transaction_details.transaction_id', $transaction->id)->get();

        return response()->json([
            'transaction' => $transaction,
            'transaction_details' => $transaction_details,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $karyawan)
    {
        return view('transaction.edit', [
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

        return redirect('/transaction')->with('success', 'Berhasil Diubah!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Transaction::where('id', $id)->delete();
        TransactionDetail::where('transaction_id', $id)->delete();
        return redirect('/transaction')->with('success', 'Berhasil Dihapus!!');
    }

    public function approve(Request $request)
    {
        $id = $request->id;
        // Mengupdate status transaksi
        $transaction = Transaction::find($id);
        if ($transaction) {
            $transaction->update([
                'status' => 'approve'
            ]);

            // Mengambil detail transaksi dan memperbarui produk terkait
            $details = TransactionDetail::where('transaction_id', $id)->get();
            foreach ($details as $detail) {
                $product = Product::find($detail->product_id);
                if ($product) {
                    if ($transaction->type == 'dipakai') {
                        // Mengupdate status produk
                        $product->update([
                            'status' => 'in_use',
                            'user_id' => $transaction->user_id
                        ]);
                    } elseif ($transaction->type == 'dikembalikan') {
                        // Mengupdate status produk
                        $product->update([
                            'status' => 'available',
                            'user_id' => null
                        ]);
                    }
                }
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil di Approve',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi tidak ditemukan',
            ]);
        }
    }

    public function tolak(Request $request)
    {
        $id = $request->id;
        // Mengupdate status transaksi
        $transaction = Transaction::find($id);
        if ($transaction) {
            $transaction->update([
                'status' => 'ditolak'
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil di Approve',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi tidak ditemukan',
            ]);
        }
    }
    public function kembalikan(Request $request)
    {
        $user = Auth::user()->role == 'karyawan' ? Auth::user()->id : $request->user;
        $date = date('Y-m-d');
        $product = Product::find($request->id);

        // return $request->products;
        // foreach ($request->products as $value) {
        //     $product = Product::find($value['asset']);

        //     // Pastikan produk ditemukan sebelum mengupdate
        //     if ($product) {
        //         $product->update([
        //             'user_id' => null,
        //             'status' => 'available',
        //         ]);

        //         // Simpan produk ke dalam array
        //         $products[] = $product;
        //     }
        // }

        $transaction = Transaction::create([
            'uuid' => "TRX" .  date('Ymd') . rand(100, 9999),
            'user_id' => $user,
            'type' => 'dikembalikan',
            'status' => Auth::user()->role == 'karyawan' ? 'pengajuan' : 'approve',
            'date' => $date,
        ]);
        $transactiondetail = TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil di Kembalikan',
        ]);

        // foreach ($products as $key => $value) {
        // $transactiondetail = TransactionDetail::create([
        //     'transaction_id' => $transaction->id,
        //     'product_id' => $value['id'],
        //     'quantity' => 1,
        // ]);
        // }
    }
}

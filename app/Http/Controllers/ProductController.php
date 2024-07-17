<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Penggajian;
use App\Models\AccessToken;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    private static $client;
    private static $hostUrl = 'https://account.accurate.id';
    private static $clientID = '8868f05f-a03b-4802-a293-61a4a79a00f2';
    private static $clientSecret = '7534ca50678ef6edecf7c56776e27a08';

    public function __construct()
    {
        self::$client = new \GuzzleHttp\Client;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Product::select('products.*', 'product_categories.name as category', 'users.name as karyawan')->leftJoin('users', 'products.user_id', '=', 'users.id')->leftJoin('product_categories', 'products.category_id', '=', 'product_categories.id')->get();

            return Datatables::of($data)->addIndexColumn()->make(true);
        }

        return view('product.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myAsset(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {

            $data = Product::select('products.*', 'product_categories.name as category')->leftJoin('product_categories', 'products.category_id', '=', 'product_categories.id')->where('user_id', $user->id)->get();

            return Datatables::of($data)->addIndexColumn()->make(true);
        }

        return view('product.myasset');
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
        $poduct = Product::select('products.*', 'product_categories.name as category', 'users.name as karyawan', DB::raw('DATE_FORMAT(products.purchase_date, "%d-%M-%Y") as purchase_date'))->leftJoin('users', 'products.user_id', '=', 'users.id')->leftJoin('product_categories', 'products.category_id', '=', 'product_categories.id')->where('products.id', $request->id)->first();

        $transaction = Transaction::select('transactions.*', DB::raw('DATE_FORMAT(transactions.date, "%d-%m-%Y") as date'), 'users.name as karyawan', 'products.name as asset', DB::raw('DATE_FORMAT(products.purchase_date, "%d-%M-%Y") as purchase_date'))->leftJoin('users', 'transactions.user_id', '=', 'users.id')->leftJoin('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')->leftJoin('products', 'transaction_details.product_id', '=', 'products.id')->where('transactions.status', 'approve')->where('transaction_details.product_id', $request->id)->get();

        return response()->json([
            'product' => $poduct,
            'transaction' => $transaction,
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

    public function getAccurate(Request $request)
    {
        $tokens = AccessToken::first();
        $alldata = null;
        try {

            $output = self::$client->request(
                'POST',
                $tokens->host . '/accurate/api/fixed-asset/list.do',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $tokens->token,
                        'X-Session-ID' => $tokens->session,
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ],
                    'json' => [
                        'sp.page' => $request->page ?? 1,
                        'sp.pageSize' => 100,
                    ],
                ]
            );

            $output = json_decode($output->getBody(), true);

            // dd($output);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $output = $responseBodyAsString;
            $output = json_decode($output, true);
            $output['success'] = false;
            $output['error'] = 'Accurate, Sedang Terjadi Gangguan!!';
        } catch (\GuzzleHttp\Exception\RequestException $er) {
            $output = $er->getResponse();
            $output['success'] = false;
            $output['error'] = 'Masalah Koneksi';
        }
        $dataid = $output['d'];
        foreach ($dataid as $index => $data) {
            try {

                $output = self::$client->request(
                    'POST',
                    $tokens->host . '/accurate/api/fixed-asset/detail.do',
                    [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $tokens->token,
                            'X-Session-ID' => $tokens->session,
                            'Content-Type' => 'application/json',
                            'Accept' => 'application/json',
                        ],
                        'json' => [
                            'id' => $data['id'],
                        ],
                    ]
                );

                $output2 = json_decode($output->getBody(), true);
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                $response = $e->getResponse();
                $responseBodyAsString = $response->getBody()->getContents();
                $output = $responseBodyAsString;
                $output = json_decode($output, true);
                $output['success'] = false;
                $output['error'] = 'Accurate, Sedang Terjadi Gangguan!!';
            } catch (\GuzzleHttp\Exception\RequestException $er) {
                $output = $er->getResponse();
                $output['success'] = false;
                $output['error'] = 'Masalah Koneksi';
            }
            $alldata[$index] = $output2;
        }
        $products = [];
        foreach ($alldata as $value) {
            if ($value['s']) {
                $data = $value['d'];
                $cekproduct = Product::where('accurate_id', $data['id'])->first();
                $category = ProductCategory::where('accurate_id', $data['faType']['id'])->first();

                if ($cekproduct === null) {
                    $products[] = Product::create([
                        'accurate_id' => $data['id'],
                        'name' => $data['description'],
                        'category_id' => $category->id,
                        'price' => $data['assetCost'],
                        'serial_number' => $data['number'],
                        'status' => 'available',
                        'purchase_date' => \Carbon\Carbon::createFromFormat('d/m/Y', $data['transDate'])->format('Y-m-d'),
                    ]);
                } else {
                    $products[] = $cekproduct->update([
                        'accurate_id' => $data['id'],
                        'name' => $data['description'],
                        'category_id' => $category->id,
                        'price' => $data['assetCost'],
                        'serial_number' => $data['number'],
                        'status' => 'available',
                        'purchase_date' => \Carbon\Carbon::createFromFormat('d/m/Y', $data['transDate'])->format('Y-m-d'),
                    ]);
                }
            }
        }

        return response()->json($products);
    }
}

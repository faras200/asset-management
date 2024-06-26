<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absen;
use App\Models\Device;
use App\Models\Karyawan;
use App\Models\Product;
use App\Models\Transaction;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard', [
            'transactions' => Transaction::select('transactions.*', 'users.name as karyawan')->leftJoin('users', 'transactions.user_id', '=', 'users.id')->get(),
            'karyawans' => User::all(),
            'assets' => Product::all(),
        ]);
    }
}

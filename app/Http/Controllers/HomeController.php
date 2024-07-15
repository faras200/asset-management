<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absen;
use App\Models\Device;
use App\Models\Karyawan;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        $user = User::find($user->id);
        if ($user->hasRole('users')) {
            return view('dashboard', [
                'transactions' => Transaction::select('transactions.*', 'users.name as karyawan')->leftJoin('users', 'transactions.user_id', '=', 'users.id')->where('transactions.status', 'approve')->where('transactions.user_id', $user->id)->orderBy('transactions.created_at', 'desc')->get(),
                'karyawans' => User::all(),
                'assets' => Product::where('user_id', $user->id)->orderBy('created_at', 'desc')->get(),
            ]);
        } else {
            return view('dashboard', [
                'transactions' => Transaction::select('transactions.*', 'users.name as karyawan')->leftJoin('users', 'transactions.user_id', '=', 'users.id')->where('transactions.status', 'approve')->get(),
                'karyawans' => User::all(),
                'assets' => Product::all(),
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $user = User::find($user->id);
        if ($request->ajax()) {

            if ($user->hasRole('users')) {
                $data = Transaction::select('transactions.*', 'users.name as karyawan')->leftJoin('users', 'transactions.user_id', '=', 'users.id')->where('transactions.user_id', $user->id)->orderBy('transactions.created_at', 'desc')->get();
            } else {
                $data = Transaction::select('transactions.*', 'users.name as karyawan')->leftJoin('users', 'transactions.user_id', '=', 'users.id')->orderBy('transactions.created_at', 'desc')->where('transactions.status', 'pengajuan')->get();
            }

            return Datatables::of($data)->addIndexColumn()->make(true);
        }

        return view('pengajuan.index');
    }
}

<?php

namespace App\Http\Controllers;

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

        if ($request->ajax()) {

            if ($user->role == 'karyawan') {
                $data = Transaction::select('transactions.*', 'users.name as karyawan')->leftJoin('users', 'transactions.user_id', '=', 'users.id')->where('transactions.user_id', $user->id)->orderBy('transactions.created_at', 'desc')->get();
            } else {
                $data = Transaction::select('transactions.*', 'users.name as karyawan')->leftJoin('users', 'transactions.user_id', '=', 'users.id')->orderBy('transactions.created_at', 'desc')->where('transactions.status', 'pengajuan')->get();
            }

            return Datatables::of($data)->addIndexColumn()->make(true);
        }

        return view('pengajuan.index');
    }
}

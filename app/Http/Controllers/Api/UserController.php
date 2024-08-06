<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function updateProfil(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        // Establish a connection to the session database
        $connection = DB::connection('session_database');

        // Retrieve user data from the session database
        $userData = $connection->table('users')->where('id', $request->id)->first();

        if ($userData) {
            // Update the User model with the retrieved data
            $update = User::findOrFail($request->id);
            $update->jenkel = $userData->jenkel;
            $update->tempat_lahir = $userData->tempat_lahir;
            $update->tgl_lahir = $userData->tgl_lahir;
            $update->no_ktp = $userData->no_ktp;
            $update->profile = 1;
            $update->no_npwp = $userData->no_npwp;
            $update->npwpbaru = $userData->npwpbaru;
            $update->no_rek = $userData->no_rek;
            $update->pemilik_rek = $userData->pemilik_rek;
            $update->bank = $userData->bank;
            $update->tgl_keluar = $userData->tgl_keluar;
            $update->jum_keluarga = $userData->jum_keluarga;
            $update->alamat = $userData->alamat;
            $update->darurat_name = $userData->darurat_name;
            $update->darurat_nohp = $userData->darurat_nohp;
            $update->darurat_hubungan = $userData->darurat_hubungan;
            $update->nohp = $userData->nohp;
            $update->save();

            echo "User information updated successfully.";
        } else {
            echo "User data not found in session_database.";
        }
    }

    public function changePassword(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'password' => 'required|min:8',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Hash password baru
        $Password = $request->password;

        // Update password user menggunakan Query Builder
        $updated = DB::table('users')
            ->where('id', $request->id)
            ->update(['password' => $Password]);

        // Cek apakah update berhasil
        if ($updated) {
            return response()->json(['message' => 'Password berhasil diubah'], 200);
        } else {
            return response()->json(['error' => 'Gagal mengubah password'], 500);
        }
    }
}

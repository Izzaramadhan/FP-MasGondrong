<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Ambil semua pengguna
    public function index()
    {
        return response()->json(User::all());
    }

    // Hapus pengguna berdasarkan ID
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 404);
        }

        $user->delete();
        return response()->json(['success' => true, 'message' => 'User berhasil dihapus']);
    }

    // Tambah pengguna baru (optional jika ingin insert)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json(['success' => true, 'data' => $user]);
    }

    // Cari pengguna berdasarkan email (sebagai pengganti getByEmail)
    public function getByEmail($email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $user]);
    }
}

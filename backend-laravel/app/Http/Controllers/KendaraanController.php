<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kendaraan;
use Illuminate\Support\Facades\Storage;

class KendaraanController extends Controller
{
    public function index()
    {
        return Kendaraan::all();
    }

    public function show($id)
    {
        $data = Kendaraan::find($id);
        return $data
            ? response()->json(['status' => 'success', 'data' => $data])
            : response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan']);
    }

    public function store(Request $request)
    {
        if (!$request->hasFile('gambar')) {
            return response()->json(['status' => false, 'error' => 'Gambar tidak ditemukan.']);
        }

        $request->validate([
            'tipe' => 'required',
            'jenis' => 'required',
            'plat_nomor' => 'required',
            'harga_perhari' => 'required|numeric',
            'gambar' => 'image|max:2048',
        ]);

        $path = $request->file('gambar')->store('public/kendaraan');
        $nama_gambar = basename($path);

        $kendaraan = Kendaraan::create([
            'tipe' => $request->tipe,
            'jenis' => $request->jenis,
            'plat_nomor' => $request->plat_nomor,
            'harga_perhari' => $request->harga_perhari,
            'gambar' => $nama_gambar,
            'status' => 'tersedia'
        ]);

        return response()->json(['status' => true, 'message' => 'Data kendaraan berhasil disimpan.']);
    }

    public function update(Request $request, $id)
    {
        $data = Kendaraan::find($id);
        if (!$data) return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);

        $data->update($request->only(['tipe', 'jenis', 'plat_nomor', 'harga_perhari', 'status']));

        return response()->json(['status' => true, 'message' => 'Data kendaraan berhasil diperbarui.']);
    }

    public function destroy($id)
{
    $data = Kendaraan::find($id);
    if (!$data) return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);

    $data->delete();
    return response()->json(['status' => true, 'message' => 'Berhasil dihapus']);
}

}

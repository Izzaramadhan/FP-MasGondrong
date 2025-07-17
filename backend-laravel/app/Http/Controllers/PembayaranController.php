<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    // Ambil semua data pembayaran dengan relasi ke pemesanan
    public function index()
    {
        $data = Pembayaran::with('pemesanan')->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    // Simpan data pembayaran baru
    public function store(Request $request)
    {
        $request->validate([
            'id_pemesanan' => 'required|integer|exists:pemesanan,id_pemesanan',
            'bukti_bayar' => 'required|file|image|max:2048', // maks. 2MB dan harus gambar
        ]);

        // Simpan file ke storage
        $file = $request->file('bukti_bayar');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('public/bukti_bayar', $filename); // simpan ke /storage/app/public/bukti_bayar

        $pembayaran = Pembayaran::create([
            'id_pemesanan' => $request->id_pemesanan,
            'bukti_bayar' => $filename,
            'status_pembayaran' => 'Menunggu Konfirmasi'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pembayaran berhasil disimpan.',
            'data' => $pembayaran
        ]);
    }

    // Update status pembayaran
    public function updateStatus(Request $request)
    {
        $request->validate([
            'id_pembayaran' => 'required|integer|exists:pembayaran,id_pembayaran',
            'status_pembayaran' => 'required|string'
        ]);

        $pembayaran = Pembayaran::find($request->id_pembayaran);

        if (!$pembayaran) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pembayaran tidak ditemukan.'
            ], 404);
        }

        $pembayaran->status_pembayaran = $request->status_pembayaran;
        $pembayaran->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status pembayaran berhasil diperbarui.',
            'data' => $pembayaran
        ]);
    }

    // Tampilkan bukti bayar berupa file gambar
    public function buktiBayar($filename)
    {
        $filePath = 'public/bukti_bayar/' . $filename;

        if (!Storage::exists($filePath)) {
            return response()->json([
                'status' => 'error',
                'message' => 'File tidak ditemukan.'
            ], 404);
        }

        return response()->file(storage_path('app/' . $filePath));
    }
}

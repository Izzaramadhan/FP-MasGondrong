<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    /**
     * Daftar kendaraan - untuk HomePage.vue
     */
    public function index(Request $request)
    {
        try {
            $query = Kendaraan::query();

            // Filter berdasarkan jenis
            if ($request->has('jenis')) {
                $query->where('jenis', $request->jenis);
            }

            // Filter berdasarkan tipe
            if ($request->has('tipe')) {
                $query->where('tipe', $request->tipe);
            }

            $kendaraan = $query->get();

            return response()->json([
                'success' => true,
                'message' => 'Data kendaraan berhasil diambil',
                'data' => $kendaraan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Detail kendaraan
     */
    public function show($id)
    {
        try {
            $kendaraan = Kendaraan::find($id);

            if (!$kendaraan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kendaraan tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Detail kendaraan berhasil diambil',
                'data' => $kendaraan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

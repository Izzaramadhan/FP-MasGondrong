<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemesanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PemesananModel');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type");

    }

    public function simpan() {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
    
        // Cek jika JSON tidak valid
        if (!is_array($data)) {
          echo json_encode(['status' => 'error', 'message' => 'Format JSON tidak valid']);
          return;
        }
    
        // Ambil nilai satu-satu dan beri nilai default jika kosong
        $id_user = isset($data['id_user']) ? $data['id_user'] : null;
        $id_kendaraan = isset($data['id_kendaraan']) ? $data['id_kendaraan'] : null;
        $tgl_mulai = isset($data['tgl_mulai']) ? $data['tgl_mulai'] : null;
        $tgl_selesai = isset($data['tgl_selesai']) ? $data['tgl_selesai'] : null;
        $total_harga = isset($data['total_harga']) ? $data['total_harga'] : 0;
    
        // Validasi data wajib
        if (!$id_user || !$id_kendaraan || !$tgl_mulai || !$tgl_selesai) {
          echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
          return;
        }
    
        $this->load->model('PemesananModel');
        $result = $this->PemesananModel->insert([
          'id_user' => $id_user,
          'id_kendaraan' => $id_kendaraan,
          'tgl_mulai' => $tgl_mulai,
          'tgl_selesai' => $tgl_selesai,
          'total_harga' => $total_harga,
          'status' => 'diproses'
        ]);
    
        echo json_encode(['status' => $result ? 'success' : 'error']);
      }

    public function riwayat($id_user)
    {
        $data = $this->PemesananModel->getRiwayatByUser($id_user);
        echo json_encode([
            'status' => true,
            'data' => $data
        ]);
    }
}

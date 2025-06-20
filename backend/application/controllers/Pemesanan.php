<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemesanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    
        // Header CORS
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
    
        // Tangani preflight request
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit(); // sangat penting untuk mengakhiri preflight
        }
    
        $this->load->model('PemesananModel');
    }
    
    
    public function index()
    {
        $data = $this->PemesananModel->get_all_with_relations();
        echo json_encode($data);
    }
    
    public function simpan() {
        $input = file_get_contents('php://input');
        log_message('debug', 'RAW INPUT: ' . $input);  // Tambahkan baris ini untuk cek input
    
        $data = json_decode($input, true);
    
        if (json_last_error() !== JSON_ERROR_NONE) {
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
          
          $id_pemesanan = $this->db->insert_id(); // ambil id terakhir
          
          echo json_encode([
            'status' => $result ? 'success' : 'error',
            'id_pemesanan' => $id_pemesanan // kirim id ke frontend
          ]);
          
        log_message('debug', 'DATA MASUK: ' . print_r($data, true));
log_message('debug', 'HASIL INSERT: ' . ($result ? 'berhasil' : 'gagal'));

      }

public function riwayat($id_user)
{
    $this->load->model('PemesananModel');
    $result = $this->PemesananModel->getRiwayatByUser($id_user);

    echo json_encode([
        'status' => true,
        'data' => $result
    ]);
}

    public function get_all() {
      $this->load->model('PemesananModel');
      $data = $this->Pemesanan_model->get_all_with_relations();
      echo json_encode($data);
  }
  public function update_status()
  {
      $json = file_get_contents('php://input');
      $data = json_decode($json, true);
  
      $id = $data['id_pemesanan'] ?? null;
      $status = $data['status'] ?? null;
  
      log_message('debug', 'API update_status: id=' . $id . ', status=' . $status);
  
      if ($id && $status) {
          $this->db->where('id_pemesanan', $id);
          $success = $this->db->update('pemesanan', ['status' => $status]);
  
          echo json_encode(['success' => $success]);
      } else {
          echo json_encode(['success' => false, 'error' => 'Invalid data']);
      }
  }
  
  
public function get_by_id($id_pemesanan)
{
    $this->load->model('PemesananModel');
    $result = $this->PemesananModel->getById($id_pemesanan);

    if ($result) {
        echo json_encode(['status' => true, 'data' => $result]);
    } else {
        echo json_encode(['status' => false, 'message' => 'Pemesanan tidak ditemukan.']);
    }
}


  
}

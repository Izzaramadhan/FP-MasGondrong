<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kendaraan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        $this->load->model('Kendaraan_model');
        header('Content-Type: application/json'); // Pastikan output JSON
    }
    public function index() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
    
        $this->load->model('Kendaraan_model');
        $data = $this->Kendaraan_model->getAll();
        echo json_encode($data);
      }
      public function get_all() {
        $this->load->model('Kendaraan_model');
        $data = $this->Kendaraan_model->get_all();
        echo json_encode($data);
    }
    

    public function delete() {
        $json = json_decode(file_get_contents("php://input"), true);
        $id = $json['id'] ?? null;
    
        log_message('error', '🔴 ID JSON: ' . $id);
    
        if (!$id) {
            echo json_encode(['status' => false, 'message' => 'ID tidak ditemukan']);
            return;
        }
    
        $this->load->model('Kendaraan_model');
        $hapus = $this->Kendaraan_model->delete($id);
    
        if ($hapus) {
            echo json_encode(['status' => true, 'message' => 'Berhasil dihapus']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal dihapus']);
        }
    }
    

    public function get_by_id($id)
    {
        $this->load->model('Kendaraan_model');
        $data = $this->Kendaraan_model->get_by_id($id);
    
        if ($data) {
            echo json_encode(['status' => 'success', 'data' => $data]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
    }
    public function simpan()
{
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST');
    header("Access-Control-Allow-Headers: Content-Type");

    log_message('error', '🚨 Data Diterima: ' . json_encode($_POST));
log_message('error', '🚨 Nama file: ' . json_encode($_FILES['gambar'] ?? 'TIDAK ADA'));


    $tipe = $this->input->post('tipe');
    $jenis = $this->input->post('jenis');
    $plat_nomor = $this->input->post('plat_nomor');
    $harga_perhari = $this->input->post('harga_perhari');
    $status = 'tersedia'; // default

    // Cek upload file
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $config['upload_path']   = './assets/vue/img/kendaraan/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size']      = 2048;
        $config['file_name']     = time() . '_' . $_FILES['gambar']['name'];

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('gambar')) {
            echo json_encode(['status' => false, 'error' => $this->upload->display_errors()]);
            return;
        } else {
            $upload_data = $this->upload->data();
            $nama_gambar = $upload_data['file_name'];
        }
    } else {
        echo json_encode(['status' => false, 'error' => 'Gambar tidak ditemukan.']);
        return;
    }

    $data = [
        'tipe' => $tipe,
        'jenis' => $jenis,
        'plat_nomor' => $plat_nomor,
        'harga_perhari' => $harga_perhari,
        'gambar' => $nama_gambar,
        'status' => $status
    ];

    $this->load->model('Kendaraan_model');
    $simpan = $this->Kendaraan_model->simpan($data);

    if ($simpan) {
        echo json_encode(['status' => true, 'message' => 'Data kendaraan berhasil disimpan.']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Gagal menyimpan kendaraan.']);
    }
}
public function update($id)
{
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Allow-Headers: Content-Type");

    // Ambil input JSON dari request body
    $json = json_decode(file_get_contents("php://input"), true);

    if (!$json) {
        echo json_encode(['status' => false, 'message' => 'Data tidak valid']);
        return;
    }

    $data = [
        'tipe' => $json['tipe'] ?? '',
        'jenis' => $json['jenis'] ?? '',
        'plat_nomor' => $json['plat_nomor'] ?? '',
        'harga_perhari' => $json['harga_perhari'] ?? 0,
        'status' => $json['status'] ?? 'tersedia'
    ];

    $this->load->model('Kendaraan_model');
    $update = $this->Kendaraan_model->update($id, $data);

    if ($update) {
        echo json_encode(['status' => true, 'message' => 'Data kendaraan berhasil diperbarui.']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Gagal memperbarui kendaraan.']);
    }
}


    
    
 }

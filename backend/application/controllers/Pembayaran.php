<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // CORS headers untuk API
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        
        $this->load->database();
        $this->load->helper(['url', 'file']);
    }
    public function index()
{
    $query = $this->db->get('pembayaran');
    $result = $query->result();

    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));
}


public function simpan()
{
    // Ambil data dari FormData
    $id_pemesanan = $this->input->post('id_pemesanan');
    $tgl_bayar = $this->input->post('tgl_bayar');
    $jml_bayar = $this->input->post('jml_bayar');
    $metode = $this->input->post('metode');

    // Validasi input
    if (empty($id_pemesanan) || empty($tgl_bayar) || empty($jml_bayar) || empty($metode)) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['message' => 'Data tidak lengkap']));
        return;
    }

    // Default nilai file_name
    $file_name = null;

    // Jika metode bukan Tunai, maka wajib upload file bukti_bayar
    if ($metode !== 'Tunai') {
        if (empty($_FILES['bukti_bayar']['name'])) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['message' => 'Bukti bayar tidak ditemukan.']));
            return;
        }

        // Konfigurasi upload
        $config['upload_path'] = FCPATH . 'assets/vue/img/bukti_bayar/';
        $config['allowed_types'] = 'jpg|jpeg|png|pdf';
        $config['max_size'] = 2048; // dalam KB
        $config['file_name'] = 'bukti_' . time();

        // Buat folder jika belum ada
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }

        // Cek apakah folder bisa ditulis
        if (!is_writable($config['upload_path'])) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['message' => 'Folder upload tidak bisa ditulis: ' . $config['upload_path']]));
            return;
        }

        // Lakukan proses upload
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('bukti_bayar')) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['message' => $this->upload->display_errors('', '')]));
            return;
        }

        // Ambil nama file hasil upload
        $upload_data = $this->upload->data();
        $file_name = $upload_data['file_name'];
    }

    // Cek apakah id_pemesanan ada di tabel pemesanan
    $cekPemesanan = $this->db->get_where('pemesanan', ['id_pemesanan' => $id_pemesanan])->row();
    if (!$cekPemesanan) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['message' => 'ID Pemesanan tidak valid.']));
        return;
    }

    // Simpan data ke database
    $data = [
        'id_pemesanan' => $id_pemesanan,
        'tgl_bayar' => $tgl_bayar,
        'jml_bayar' => $jml_bayar,
        'metode' => $metode,
        'status' => 'belum lunas',
        'bukti_bayar' => $file_name
    ];

    $this->db->insert('pembayaran', $data);

    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(['message' => 'Pembayaran berhasil disimpan!']));
}


    // Untuk permintaan OPTIONS (preflight CORS)
    public function options()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        exit(0);
    }
    public function update_status()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
    
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);
    
        $id = $data['id_pembayaran'] ?? null;
        $status = $data['status'] ?? null;
    
        if ($id && $status) {
            $this->db->where('id_pembayaran', $id);
            $success = $this->db->update('pembayaran', ['status' => $status]);
    
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
        }
    }
    
}

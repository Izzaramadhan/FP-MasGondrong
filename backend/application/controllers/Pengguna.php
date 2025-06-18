<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Ambil semua pengguna
    public function index() {
        $query = $this->db->get('user'); // asumsi tabel: user
        echo json_encode($query->result());
    }

    // Hapus pengguna berdasarkan ID
    public function delete($id) {
        $this->db->where('id', $id);
        $deleted = $this->db->delete('user');
        if ($deleted) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Gagal menghapus data']);
        }
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
    // File: application/config/config.php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    }
    public function register()
    {
        // Ambil input JSON
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        // Cek apakah data valid
        if (!$data || !isset($data['nama'], $data['email'], $data['password'])) {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
            return;
        }

        $this->load->database();

        $user = [
            'nama' => $data['nama'],
            'email' => $data['email'],
            'no_hp' => $data['no_hp'],
            'alamat' => $data['alamat'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ];

        $this->db->insert('user', $user);

        echo json_encode(['status' => 'success', 'message' => 'User registered successfully']);
    }

    public function login()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!$data || !isset($data['email'], $data['password'])) {
            echo json_encode(['status' => 'error', 'message' => 'Email dan password wajib diisi']);
            return;
        }

        $this->load->database();
        $user = $this->db->get_where('user', ['email' => $data['email']])->row_array();

        if ($user && password_verify($data['password'], $user['password'])) {
            unset($user['password']); // jangan kirim password ke frontend
            echo json_encode(['status' => 'success', 'message' => 'Login berhasil', 'user' => $user]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Email atau password salah']);
        }
    }
}

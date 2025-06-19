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
        $id = $this->input->post('id');
        $this->load->model('Kendaraan_model');
        $this->Kendaraan_model->delete($id);
        echo json_encode(['status' => 'deleted']);
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
    
    
 }

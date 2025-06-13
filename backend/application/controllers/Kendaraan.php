<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kendaraan extends CI_Controller {

    public function __construct() {
        parent::__construct();
// File: application/config/config.php
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
 }

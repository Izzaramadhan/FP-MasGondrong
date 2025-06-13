<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// application/controllers/Api.php
class Api extends CI_Controller {
    public function users() {
        header("Access-Control-Allow-Origin: *");
        $query = $this->db->get('users');
        echo json_encode($query->result());
    }
}

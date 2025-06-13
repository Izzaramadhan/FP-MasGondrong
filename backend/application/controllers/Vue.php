<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// application/controllers/Vue.php
class Vue extends CI_Controller {
    public function index() {
        $this->load->view('vue/index');
    }
}

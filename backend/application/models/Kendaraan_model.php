<?php
class Kendaraan_model extends CI_Model {

    public function getAll()
    {
        return $this->db->get('kendaraan')->result();
    }
}

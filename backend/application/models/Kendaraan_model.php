<?php
class Kendaraan_model extends CI_Model {

    public function getAll()
    {
        return $this->db->get('kendaraan')->result();
    }
    public function delete($id) {
        return $this->db->delete('sewa_kendaraan', ['id_kendaraan' => $id]);
    }
}

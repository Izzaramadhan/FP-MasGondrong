<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kendaraan_model extends CI_Model {

    public function getAll() {
        return $this->db->get('kendaraan')->result_array();
    }

    public function get_all() {
        return $this->db->get('kendaraan')->result_array();
    }

    public function get_by_id($id) {
        return $this->db->get_where('kendaraan', ['id_kendaraan' => $id])->row_array();
    }

    public function delete($id) {
        return $this->db->delete('kendaraan', ['id_kendaraan' => $id]);
    }
    public function simpan($data)
{
    return $this->db->insert('kendaraan', $data);
}
public function update($id, $data)
{
    $this->db->where('id_kendaraan', $id);
    return $this->db->update('kendaraan', $data);
}

}

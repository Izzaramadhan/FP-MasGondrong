<?php
class PemesananModel extends CI_Model {

    public function getRiwayatByUser($id_user) {
        $this->db->select('p.id_pemesanan, p.tgl_mulai, p.total_harga, p.status, k.tipe as kendaraan');
        $this->db->from('sewa_kendaraan_pemesanan p');
        $this->db->join('sewa_kendaraan_kendaraan k', 'p.id_kendaraan = k.id_kendaraan');
        $this->db->where('p.id_user', $id_user);
        $this->db->order_by('p.tgl_mulai', 'DESC');
        return $this->db->get()->result();
    }
    public function insert($data) {
        return $this->db->insert('pemesanan', [
          'id_user' => $data['id_user'],
          'id_kendaraan' => $data['id_kendaraan'],
          'tgl_mulai' => $data['tgl_mulai'],
          'tgl_selesai' => $data['tgl_selesai'],
          'total_harga' => $data['total_harga'],
          'status' => 'diproses'
        ]);
      }
}

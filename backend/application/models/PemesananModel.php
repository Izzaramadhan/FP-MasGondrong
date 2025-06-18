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
      public function get_all_with_relations() {
        $this->db->select('p.*, u.nama as nama_user, k.tipe as nama_kendaraan');
        $this->db->from('pemesanan p'); // ✅ Ubah dari sewa_kendaraan_pemesanan
        $this->db->join('user u', 'p.id_user = u.id_user'); // ubah jika tabel user beda
        $this->db->join('kendaraan k', 'p.id_kendaraan = k.id_kendaraan'); // ubah jika tabel kendaraan beda
        return $this->db->get()->result();
    }
    public function update_status()
    {
        $id = $this->input->post('id_pemesanan');
        $status = $this->input->post('status');
    
        error_log("DEBUG update_status - id: $id, status: $status");
    
        if ($id && $status) {
            $result = $this->PemesananModel->updateStatus($id, $status);
            echo json_encode(['status' => $result ? 'success' : 'error']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
        }
    }
    
    
  }

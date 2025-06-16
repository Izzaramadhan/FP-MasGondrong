<?php
class User_model extends CI_Model {
  private $table = 'user';

  public function insert($data) {
    return $this->db->insert($this->table, $data);
  }

  public function getByEmail($email) {
    return $this->db->get_where($this->table, ['email' => $email])->row_array();
  }
}

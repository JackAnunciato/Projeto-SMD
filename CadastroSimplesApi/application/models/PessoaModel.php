<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PessoaModel extends CI_Model {

    public function get_all() {
        return $this->db->get('pessoas')->result_array();
    }

    public function get($id) {
        return $this->db->get_where('pessoas', array('id' => $id))->row_array();
    }

    public function insert($data) {
        $this->db->insert('pessoas', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('pessoas', $data);
    }

    public function delete($id) {
        return $this->db->delete('pessoas', array('id' => $id));
    }
}
?>

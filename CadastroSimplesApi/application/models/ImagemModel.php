<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ImagemModel extends CI_Model {

    public function get_by_pessoa_id($pessoa_id) {
        $this->db->where('pessoa_id', $pessoa_id);
        $this->db->order_by('id', 'DESC');  // Ordena pelo ID em ordem decrescente
        $this->db->limit(1);  // Limita a 1 resultado
        return $this->db->get('imagens_pessoas')->row_array();
    }
    

    public function insert($data) {
        return $this->db->insert('imagens_pessoas', $data);
    }

    public function update_by_pessoa_id($pessoa_id, $data) {
        $this->db->where('pessoa_id', $pessoa_id);
        return $this->db->update('imagens_pessoas', $data);
    }

    public function delete_by_pessoa_id($pessoa_id) {
        return $this->db->delete('imagens_pessoas', array('pessoa_id' => $pessoa_id));
    }
}
?>

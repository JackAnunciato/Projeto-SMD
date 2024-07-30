<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_ImagensPessoas extends CI_Migration {

    public function up() {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'pessoa_id' => [
                'type' => 'INT',
                'unsigned' => TRUE,
                'constraint' => 11
            ],
            'imagem_base64' => [
                'type' => 'LONGTEXT' // Armazene a imagem como base64
            ]
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('imagens_pessoas');
        $this->db->query('ALTER TABLE imagens_pessoas ADD CONSTRAINT fk_pessoa_id FOREIGN KEY (pessoa_id) REFERENCES pessoas(id)');
    }

    public function down() {
        $this->dbforge->drop_table('imagens_pessoas');
    }
}

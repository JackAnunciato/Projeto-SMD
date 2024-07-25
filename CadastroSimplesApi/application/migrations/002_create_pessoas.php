<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_pessoas extends CI_Migration {

    public function up() {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'telefone' => [
                'type' => 'VARCHAR',
                'constraint' => 15 
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'data_nascimento' => [
                'type' => 'DATE'
            ],
            'idade' => [
                'type' => 'INT',
                'constraint' => 3
            ],
            'created_at' => [
            'type' => 'DATETIME',
            ]
        ]);

        

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('pessoas');
    }

    public function down() {
        $this->dbforge->drop_table('pessoas');
    }
}

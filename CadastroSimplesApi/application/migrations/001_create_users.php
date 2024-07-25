<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_users extends CI_Migration {
    public function up() {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'username' => array(
                'type' => 'VARCHAR',
                'constraint' => 100
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users');
        $data = array(
            'username' => 'admin',
            'password' => password_hash('1233', PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s')
        );
        $this->db->insert('users', $data);
    }

    public function down() {
        $this->dbforge->drop_table('users');
    }
}

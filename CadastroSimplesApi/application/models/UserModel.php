<?php
class UserModel extends CI_Model {
    protected $table = 'users'; // Nome da tabela no banco de dados
    protected $primaryKey = 'id'; // Chave primária da tabela
    protected $allowedFields = ['username', 'password']; // Campos permitidos para inserção/atualização

    public function getUserLogin($username) {
        // Consulta o banco de dados para encontrar o usuário com o nome de usuário fornecido
        return $this->db->where('username', $username)->get($this->table)->row();
    }
}

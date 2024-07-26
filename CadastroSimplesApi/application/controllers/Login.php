<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin: http://localhost:5173');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    }

    public function autenticar() {
        $json = trim(file_get_contents('php://input'));
        $data = json_decode($json, true);

        if (isset($data['username']) && isset($data['password'])) {
            $username = $data['username'];
            $password = $data['password'];

            $this->load->model('UserModel');
            $usuario = $this->UserModel->getUserLogin($username);

            if ($usuario && password_verify($password, $usuario->password)) {
                $response = array(
                    'success' => true,
                    'message' => 'Usuário autenticado com sucesso.'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Nome de usuário ou senha incorretos.'
                );
            }
        } else {
            $response = array(
                'success' => false,
                'message' => 'Dados de login ausentes no JSON.'
            );
        }

        echo json_encode($response);
    }
}

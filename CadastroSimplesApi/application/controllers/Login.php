<?php
class Login extends CI_Controller {
        public function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin: http://localhost:5173'); // Permite apenas a origem do seu frontend
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Métodos permitidos
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding"); // Cabeçalhos permitidos
    }
    public function autenticar() {
        $json = trim(file_get_contents('php://input'));

        // Decodificar o JSON em um array associativo
        $data = json_decode($json, true);

        // Verificar se os campos 'username' e 'password' estão presentes
        if (isset($data['username']) && isset($data['password'])) {
            $username = $data['username'];
            $password = $data['password'];
            // Consulta o banco de dados para verificar o usuário
            $this->load->model('UserModel'); // Carrega o model de usuários (crie esse model)
            $usuario = $this->UserModel->getUserLogin($username);
    
            if ($usuario) {
                // Usuário encontrado, agora verifique a senha
                // if ($password == $usuario->password)
                if (password_verify($password, $usuario->password))
                 {
                    // Senha correta, usuário autenticado com sucesso
                    // Defina a sessão ou gere um token JWT, conforme sua preferência
                    // Envie uma resposta de sucesso para o front-end
                    $response = array(
                        'success' => true,
                        'message' => 'Usuário autenticado com sucesso.'
                    );
                    echo json_encode($response);
                } else {
                    // Senha incorreta
                    // Envie uma resposta de erro para o front-end
                    $response = array(
                        'success' => false,
                        'message' => 'Senha incorreta.'
                    );
                    echo json_encode($response);
                }
            } else {
                // Usuário não encontrado
                // Envie uma resposta de erro para o front-end
                $response = array(
                    'success' => false,
                    'message' => 'Usuário não encontrado.'
                );
                echo json_encode($response);
            }
        } else {
            // Caso os campos estejam ausentes no JSON
            $response = array(
                'success' => false,
                'message' => 'Dados de login ausentes no JSON.'
            );
        }

        // Enviar a resposta como JSON
        echo json_encode($response);
    
    }
}

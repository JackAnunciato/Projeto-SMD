<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PessoaController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin: http://localhost:5173'); // Permitir apenas a origem do seu frontend
        header("Access-Control-Allow-Methods: GET, POST,PUT,DELETE, OPTIONS"); // Métodos permitidos
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        $this->load->model('PessoaModel');
        $this->load->model('ImagemModel');
        $this->load->helper('url');
    }

    public function store() {    
        $pessoa_data = array(
            'nome' => $this->input->post('nome'),
            'telefone' => $this->input->post('telefone'),
            'email' => $this->input->post('email'),
            'data_nascimento' => $this->input->post('data_nascimento'),
            'idade' => $this->input->post('idade'),
            'created_at' => date('Y-m-d H:i:s')
        );
    
        if (isset($pessoa_data['nome'], $pessoa_data['telefone'], $pessoa_data['email'], $pessoa_data['data_nascimento'], $pessoa_data['idade'])) {
            $pessoa_id = $this->PessoaModel->insert($pessoa_data);
    
            
            $imagem_base64 = $this->input->post('imagem'); 
            if (!empty($imagem_base64)) {
                
                $imagem_data = array(
                    'pessoa_id' => $pessoa_id,
                    'imagem_base64' => $imagem_base64
                );
                
                $this->ImagemModel->insert($imagem_data);
            }
    
            
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Dados incompletos']);
        }
    }
    
    public function index() {
        $data['pessoas'] = $this->PessoaModel->get_all();
        echo json_encode($data);
    }

    public function show($id) {
        $data['pessoa'] = $this->PessoaModel->get($id);
        $data['imagem'] = $this->ImagemModel->get_by_pessoa_id($id);
        echo json_encode($data);
    }



    public function update($id) {

        // var_dump($parsed_data);
    
        // Dados da pessoa
        $pessoa_data = array(
            'nome' => $this->input->post('nome'),
            'telefone' => $this->input->post('telefone'),
            'email' => $this->input->post('email'),
            'data_nascimento' => $this->input->post('data_nascimento'),
            'idade' => $this->input->post('idade')
        );
    

        $this->PessoaModel->update($id, $pessoa_data);
    

        if (isset($_FILES['imagem']) && !empty($_FILES['imagem']['name'])) {

            $imagem_base64 = base64_encode(file_get_contents($_FILES['imagem']['tmp_name']));
            $imagem_data = array(
                'imagem_base64' => $imagem_base64
            );
            $this->ImagemModel->update_by_pessoa_id($id, $imagem_data);
        }
    
        echo json_encode(['status' => 'success']);
    }
    

    public function delete($id) {
        $this->ImagemModel->delete_by_pessoa_id($id);
        $this->PessoaModel->delete($id);
        echo json_encode(['status' => 'success']);
    }
}
?>

<?php

namespace App\Controllers;


use CodeIgniter\RESTful\ResourceController;
use Exception;

class Usuario extends ResourceController
{
    private $usuarioModel;

    public function __construct(){
        $this->usuarioModel = new \App\Models\UsuarioModel();
    }



    // metodo para criar um usuario
    public function create()
    {
        try {
            $input = $this->request->getJSON(true);

            if (!$input) {
                return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'JSON inválido ou malformado']);
            }

            $requiredFields = ['nome', 'email', 'password'];
            foreach ($requiredFields as $field) {
                if (!isset($input[$field]) || empty($input[$field])) {
                    return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => "Campo '$field' é obrigatório e não pode ser vazio"]);
                }
            }

            $email = $input['email'];

            // Verifica se o email já existe na base de dados
            $existingUser = $this->usuarioModel->where('email', $email)->first();
            if ($existingUser) {
                return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'Email já está em uso']);
            }

            $data = [
                'nome' => $input['nome'],
                'email' => $input['email'],
                'password' => password_hash($input['password'], PASSWORD_BCRYPT)  // Hash da senha antes de salvar
            ];

            if ($this->usuarioModel->insert($data)) {
                return $this->response->setStatusCode(201)->setJSON(['status' => 'success', 'message' => 'Usuário criado com sucesso']);
            } else {
                return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'message' => 'Falha ao criar o usuário']);
            }
        } catch (Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
                //metodo para validar o usuario
    public function login()
    {
        try {
            $input = $this->request->getJSON(true);

            if (!$input) {
                return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'JSON inválido ou malformado']);
            }

            $requiredFields = ['email', 'password'];
            foreach ($requiredFields as $field) {
                if (!isset($input[$field]) || empty($input[$field])) {
                    return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => "Campo '$field' é obrigatório e não pode ser vazio"]);
                }
            }

            $email = $input['email'];
            $password = $input['password'];

            $user = $this->usuarioModel->where('email', $email)->first();

            if (!$user) {
                return $this->response->setStatusCode(401)->setJSON(['status' => 'error', 'message' => 'Email ou senha incorretos']);
            }

            // Verifique se a senha fornecida corresponde ao hash armazenado
            if (!password_verify($password, $user['password'])) {
                return $this->response->setStatusCode(401)->setJSON(['status' => 'error', 'message' => 'Senha incorreta']);
            }

            return $this->response->setStatusCode(200)->setJSON(['status' => 'success', 'message' => 'Login realizado com sucesso', 'data' => ['user_id' => $user['id'], 'nome' => $user['nome'], 'email' => $user['email']]]);
        } catch (Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
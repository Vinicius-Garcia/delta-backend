<?php

namespace App\Controllers;


use CodeIgniter\RESTful\ResourceController;
use Exception;

class Alunos extends ResourceController
{
    private $alunoModel;

    public function __construct(){
        $this->alunoModel = new \App\Models\AlunosModel();
    }

    //metedo para buscar os alunos

    public function list()
    {
        $data = $this->alunoModel->findAll();
        return $this->response->setJSON($data);
    }

    // metodo para inserir um novo aluno

    public function create()
    {
        try {
            // Tenta obter os dados JSON da requisição
            $input = $this->request->getJSON(true); // O parâmetro true retorna um array associativo

            // Verifica se os dados foram recebidos corretamente
            if (!$input) {
                return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'JSON inválido ou malformado']);
            }

            // Verifica se todos os campos necessários estão presentes e não são vazios
            $requiredFields = ['nome', 'email', 'telefone', 'endereco'];
            foreach ($requiredFields as $field) {
                if (!isset($input[$field]) || empty($input[$field])) {
                    return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => "Campo '$field' é obrigatório e não pode ser vazio"]);
                }
            }

            // Prepara os dados para inserção
            $data = [
                'nome' => $input['nome'],
                'email' => $input['email'],
                'telefone' => $input['telefone'],
                'endereco' => $input['endereco']
            ];

            // Insere os dados no banco de dados
            if ($this->alunoModel->insert($data)) {
                // Retorna uma resposta de sucesso
                return $this->response->setStatusCode(201)->setJSON(['status' => 'success', 'message' => 'Aluno criado com sucesso']);
            } else {
                // Retorna uma resposta de erro se a inserção falhar
                return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'message' => 'Falha ao criar o aluno']);
            }
        } catch (Exception $e) {
            // Em caso de erro, retorna uma resposta de erro com a mensagem da exceção
            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function update($id = null)
    {
        try {
            if (!$id) {
                return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'ID não fornecido']);
            }

            $input = $this->request->getJSON(true);

            if (!$input) {
                return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'JSON inválido ou malformado']);
            }

            $data = [];
            if (isset($input['nome'])) $data['nome'] = $input['nome'];
            if (isset($input['email'])) $data['email'] = $input['email'];
            if (isset($input['telefone'])) $data['telefone'] = $input['telefone'];
            if (isset($input['endereco'])) $data['endereco'] = $input['endereco'];

            if (empty($data)) {
                return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'Nenhum dado fornecido para atualização']);
            }

            if ($this->alunoModel->update($id, $data)) {
                return $this->response->setStatusCode(200)->setJSON(['status' => 'success', 'message' => 'Aluno atualizado com sucesso']);
            } else {
                return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'message' => 'Falha ao atualizar o aluno']);
            }
        } catch (Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function delete($id = null)
    {
        try {
            if (!$id) {
                return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'ID não fornecido']);
            }

            if ($this->alunoModel->delete($id)) {
                return $this->response->setStatusCode(200)->setJSON(['status' => 'success', 'message' => 'Aluno deletado com sucesso']);
            } else {
                return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'message' => 'Falha ao deletar o aluno']);
            }
        } catch (Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


}
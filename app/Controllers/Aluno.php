<?php

namespace App\Controllers;

use App\Models\AlunoModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Aluno extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $model = new AlunoModel();
        $data = $model->findAll();
        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $model = new AlunoModel();
        $data = $model->find(['id'  => $id]);
        if (!$data) return $this->failNotFound('No Data Found');
        return $this->respond($data[0]);
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {


    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        helper(['form', 'url']);
        $rules = [
            'nome' => 'required',
            'email' => 'required',
            'telefone' => 'required',
            'endereco' => 'required',
            'foto' => 'required',
        ];
        $data = [
            "nome" => $this->request->getPost('nome'),
            "email" => $this->request->getPost('email'),
            "telefone" => $this->request->getPost('telefone'),
            "endereco" => $this->request->getPost('endereco'),
            "foto" => $this->request->getPost('foto')
        ];
        if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $model = new AlunoModel();
        $model->create($data);
        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Data Inserted'
            ]
        ];
        return $this->respondCreated($response);
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {

    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        helper(['form']);
        $rules = [
            'nome' => 'required',
            'email' => 'required',
            'telefone' => 'required',
            'endereco' => 'required',
            'foto' => 'required',
        ];
        $data = [
            "nome" => $this->request->getPost('nome'),
            "email" => $this->request->getPost('email'),
            "telefone" => $this->request->getPost('telefone'),
            "endereco" => $this->request->getPost('endereco'),
            "foto" => $this->request->getPost('foto')
        ];
        if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $model = new AlunoModel();
        $find = $model->find(['id' => $id]);
        if(!$find) return $this->failNotFound('No Data Found');
        $model->update($id, $data);

        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data updated'
            ]
        ];
        return $this->respond($response);
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        $model = new AlunoModel();
        $find = $model->find(['id' => $id]);
        if(!$find) return $this->failNotFound('No Data Found');
        $model->delete($id);

        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data deleted'
            ]
        ];
        return $this->respond($response);
    }
}

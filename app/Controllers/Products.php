<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModel;
class Products extends ResourceController
{
    use ResponseTrait;
    public function index()
    {
        $model = new ProductModel();
        $data = $model->findAll();
        return $this->respond($data);
    }
    public function show($id = null)
    {
        $model = new ProductModel();
        $data = $model->find(['id'  => $id]);
        if (!$data) return $this->failNotFound('No Data Found');
        return $this->respond($data[0]);
    }
    public function create() {
        helper(['form']);
        $rules = [
            'title' => 'required',
            'price' => 'required'
        ];
        $data = [
            'title' => $this->request->getVar('title'),
            'price' => $this->request->getVar('price')
        ];

        if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $model = new ProductModel();
        $model->save($data);
        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Data Inserted'
            ]
        ];
        return $this->respondCreated($response);
    }
    public function update($id=null) {
        helper(['form']);
        $rules = [
            'title' => 'required',
            'price' => 'required'
        ];
        $data = [
            'title' => $this->request->getVar('title'),
            'price' => $this->request->getVar('price')
        ];

        if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $model = new ProductModel();
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
    public function delete($id=null) {
        $model = new ProductModel();
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
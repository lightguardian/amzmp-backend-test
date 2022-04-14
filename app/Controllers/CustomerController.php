<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CustomerController extends ResourceController
{
    protected $builder;
    private $customer;
    private $userController;
    private $validation;
    private $auth;

    public function __construct() 
    {
        $this->validation =  \Config\Services::validation();    
        $this->customer = new \App\Models\Customer();
        $this->auth = new \App\Controllers\AuthController();
    }

    public function index() 
    {
        if(!$this->auth->authenticate($this->request)) {
            $this->response->setStatusCode(401);
            return $this->response->setJson([
                'status' => false, 
                'message' => 'Não autorizado.'
            ]);
        }

        try {
            $data = $this->customer->findAll();
        } 
        catch (\Exception $e) {
            $this->response->setStatusCode(500);
            return $this->response->setJson([
                'status' => false,
                'message' => 'Erro interno do servidor!'
            ]);
        }

        if($data !== null) {
            $this->response->setStatusCode(202);
            return $this->response->setJson($data);
        } 

        $this->response->setStatusCode(404);
        return $this->response->setJson([
            'status' => false, 
            'message' => 'Nenhum cliente encontrado.'
        ]);
        
        
    }

    public function show($id = null) 
    {   
        if(!$this->auth->authenticate($this->request)) {
            $this->response->setStatusCode(401);
            return $this->response->setJson([
                'status' => false, 
                'message' => 'Não autorizado.'
            ]);
        }

        if($id === null) {
            $this->response->setStatusCode(404);
            return $this->response->setJson([
                'status' => false,
                'message' => 'Dados inválidos'
            ]);
        }

        try {
            $data = $this->customer->find($id);
        }
        catch (\Exception $e) {
            $this->response->setStatusCode(500);
            return $this->response->setJson([
                'status' => false,
                'message' => 'Erro interno do servidor!'
            ]);
        }

        if($data !== null) {
            $this->response->setStatusCode(202);
            return $this->response->setJson($data);

        } 
        $this->response->setStatusCode(404);
        return $this->response->setJson([
            'status' => false, 
            'message' => 'Nenhum cliente com ID [' . $id . '] encontrado.'
        ]);
    }

    public function create()
    {   
        if(!$this->auth->authenticate($this->request)) {
            $this->response->setStatusCode(401);
            return $this->response->setJson([
                'status' => false, 
                'message' => 'Não autorizado.'
            ]);
        }

        $request = (array) $this->request->getJson();

        if ($this->validation->run($request,'fiscalCustomerCreate')) {
            try {
                $this->customer->table('fiscal_customer')->insert($request);
                $this->response->setStatusCode(202);
                return $this->response->setJson([
                    'status' => true,
                    'message' => 'Cliente cadastrado com sucesso!'
                ]);
            }
            catch (\Exception $e)
            {
                $this->response->setStatusCode(500);
                return $this->response->setJson([
                    'status' => false,
                    'message' => 'Dados inválidos'
                ]);
            }
        } else {
            $this->response->setStatusCode(202);
            return $this->response->setJson([
                'status' => false,
                'message' => 'Dados inválidos'
            ]);
        }
    }

    public function update($id = null)
    {   
        if(!$this->auth->authenticate($this->request)) {
            $this->response->setStatusCode(401);
            return $this->response->setJson([
                'status' => false, 
                'message' => 'Não autorizado.'
            ]);
        }

        $request = (array) $this->request->getJson();

        $query = $this->customer->where('id', $id)->first();

        if ($this->validation->run($request,'fiscalCustomerUpdate') && $query) 
        {
            try {      
                $this->customer->update($id, $request);

                $this->response->setStatusCode(202);
                return $this->response->setJson([
                    'status' => true,
                    'message' => 'Cliente atualizado com sucesso!'
                ]);
            }
            catch (\Exception $e)
            {   
                $this->response->setStatusCode(500);
                return $this->response->setJson([
                    'status' => false,
                    'message' => 'Dados inválidos'
                ]);
            }
        } else {
            $this->response->setStatusCode(404);
            return $this->response->setJson([
                'status' => false,
                'message' => 'Dados inválidos'
            ]);
        }
    }

    public function remove($id = null) {
        if(!$this->auth->authenticate($this->request)) {
            $this->response->setStatusCode(401);
            return $this->response->setJson([
                'status' => false, 
                'message' => 'Não autorizado.'
            ]);
        }

        try {
            if($this->customer->where('id', $id)->first()) {
                $this->customer->delete($id);

                $this->response->setStatusCode(202);
                return $this->response->setJson([
                    'status' => true,
                    'message' => 'Usuário excluído com suceso'
                ]);
            }
            $this->response->setStatusCode(404);
            return $this->response->setJson([
                'status' => false,
                'message' => 'Dados inválidos'
            ]);
        }
        catch (\Exception $e)
        {
            $this->response->setStatusCode(500);

            return $this->response->setJson([
                'status' => false,
                'message' => 'Erro interno'
            ]);
        }
    }


}

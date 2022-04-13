<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class UserController extends ResourceController
{
    private $user;
    private $validation;
    private $encrypter;
    
    public function __construct() {
        $this->user = new \App\Models\User();
        $this->validation =  \Config\Services::validation();    
   }

    public function index()
    {
        //
    }

    public function create()
    {
        $request = $this->request->getJson();

        if ($this->validation->run((array) $request,'UserCreate')) {

            $request->password = password_hash($request->password, PASSWORD_DEFAULT);

            try {
                $this->user->table('user')->insert($request);
                $this->response->setStatusCode(202);
                return $this->response->setJson([
                    'status' => true,
                    'message' => 'Usuário cadastrado com sucesso!'
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

    public function login() {
        
    }
}

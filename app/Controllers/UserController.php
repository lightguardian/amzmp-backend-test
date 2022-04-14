<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class UserController extends ResourceController
{
    private $user;
    private $validation;
    private $encrypter;
    private $auth;
    private $session;
    
    public function __construct() {
        $this->user = new \App\Models\User();
        $this->auth = new \App\Controllers\AuthController();
        $this->validation =  \Config\Services::validation();    
        $this->session = \Config\Services::session();
   }

    public function create()
    {
        $request = $this->request->getJson();

        if ($this->validation->run((array) $request,'userCreate')) {

            $request->password = password_hash($request->password, PASSWORD_DEFAULT);

            try {
                $this->user->table('user')->insert($request);
                $this->response->setStatusCode(202);
                return $this->response->setJson([
                    'status' => true,
                    'message' => 'Usuário cadastrado com sucesso!'
                ]);
            }
            catch(\Exception $e)
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

    public function login() 
    {
        $request = $this->request->getJson();

        if ($this->validation->run((array) $request,'userLogin')) {

            $userData = null;

            try {
                $userData = $this->user->where('email', $request->email)
                ->first();
            }
            catch(\Exception $e)
            {
                $this->response->setStatusCode(500);
                return $this->response->setJson([
                    'status' => false,
                    'message' => 'Erro interno'
                ]);
            }                
          
            if($userData && password_verify( $request->password, $userData["password"])) {
                $token = $this->auth->giveToken();

                $newdata = [
                    'name'      => $userData['name'],
                    'email'     => $userData['email'],
                    'token'     => $token,
                ];
                
                $this->session->set(['userSession'=>$newdata]);
                $this->session->markAsTempdata('userSession', 259200);
                
                $this->response->setStatusCode(202);
                return $this->response->setJson([
                    'status' => true,
                    'message' => 'Login efetuado com sucesso!',
                    'data' => $this->session->userSession
                ]);
            }

            $this->response->setStatusCode(401);
            return $this->response->setJson([
                'status' => false,
                'message' => 'Email ou senha incorretos!'
            ]);

        } else {
            $this->response->setStatusCode(202);
            return $this->response->setJson([
                'status' => false,
                'message' => 'Dados inválidos'
            ]);
        }
    }

    public function logout()
    {
        $this->session->stop();
        $this->response->setStatusCode(202);
        return $this->response->setJson([
            'status' => true,
            'message' => 'Até mais!'
        ]);
    } 
}

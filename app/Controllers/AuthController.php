<?php

namespace App\Controllers;

use App\Controllers\BaseController;

define('SECRET_KEY', $_SERVER['SECRET_KEY']);

class AuthController extends BaseController
{
    public function authenticate($request = null) {
        $token = str_replace('Bearer ', '',$request->getServer('HTTP_AUTHORIZATION'));

        return $token !== null && $this->checkToken($token);
    }

    public function checkToken($token) {
        return password_verify(SECRET_KEY, $token); 
    }

    public function giveToken() {
        return password_hash(SECRET_KEY, PASSWORD_DEFAULT);;
    }
}

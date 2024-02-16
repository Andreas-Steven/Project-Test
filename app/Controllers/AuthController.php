<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

use App\Models\UsersModel;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;

class AuthController extends ResourceController
{
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return ResponseInterface
     */
    public function register()
    {
        $rules = $this->validate([
            'name'              => 'required',
            'email'             => 'required|valid_email',
            'password'          => 'required|min_length[6]',
        ]);

        if ($rules) {
            $userModel = new UsersModel;
            $userData = [
                'name'     => $this->request->getVar('name'),
                'email'     => $this->request->getVar('email'),
                'password'  => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT)
            ];
            $userModel->save($userData);

            $response = [
                'status'    => true,
                'message'     => 'Registration success'
            ];

            return $this->respond($response, 200);
        } else {
            return $this->failValidationErrors($this->validator->getErrors(''));
        }
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return ResponseInterface
     */
    public function login($id = null)
    {
        $userModel  = new UsersModel;
        $email      = $this->request->getVar('email');
        $password   = $this->request->getVar('password');
        $user       = $userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            $response = [
                'status'    => false,
                'message'   => 'Email address or password is incorrect'
            ];
            
            return $this->respond($response, 401);
        }

        $key        = 'z0s7wbi0dsilktlgbxb5fzmegxaxke4sy87afp4ndav1v47y19s1w1jmcrdt';
        $iat        = time();
        $exp        = $iat + (60*60);
        $payload    = [
            'iss'   => 'CI-RESTAPI',
            'sub'   => 'logintoken',
            'iat'   => $iat,
            'exp'   => $exp,
            'email' => $email
        ]; 
        $token = JWT::encode($payload, $key, "HS256");

        $response = [
            'status'    => true,
            'token'     => $token
        ];

        return $this->respond($response, 200);
    }
}

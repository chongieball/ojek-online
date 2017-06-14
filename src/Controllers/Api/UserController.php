<?php

namespace App\Controllers\Api;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


class UserController extends \App\Controllers\BaseController
{
    public function register(Request $request, Response $response)
    {
        $post = $request->getParams();

        $rule = [
            'required' => [
                ['name'],
                ['username'],
                ['email'],
                ['password'],
                ['phone'],
            ],
            'email' => [
                ['email'],
            ],
            'lengthMin' => [
                ['username', 6],
                ['password', 6],
            ],
        ];

        $this->validator->rules($rule);

        if ($this->validator->validate()) {
            $userRepo = new \App\Repositories\UserRepository;
            $register = $userRepo->register($post);

            if (key($register) === 'errors') {
                return $this->responseDetail('Error', 400, $register['errors']);
            }

            $this->mailer->send('templates/mailer/activate.twig', ['user' => $register], function($message) use ($register) {
                    $message->to($register['email']);
                    $message->subject('Activation Account');
            });

            return $this->responseDetail("Register Success", 201, $register);
        }  else {
            return $this->responseDetail("Error", 400, $this->validator->errors());
        }
    }

    public function activate(Request $request, Response $response)
    {
        $activateRepo = new \App\Repositories\UserRepository;

        $token = $request->getParam('token');
    }
}
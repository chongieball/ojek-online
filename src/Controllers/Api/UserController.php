<?php

namespace App\Controllers\Api;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;

class UserController extends \App\Controllers\BaseController
{
    private function setJwt($dataUser)
    {
        $getJwtToken = $this->container->get('settings')['jwt']['token'];

        $jti = base64_encode($getJwtToken);
        $now = new \DateTime();
        $future = new \DateTime("now +2 day");
        $payload = [
            "iat" => $now->getTimeStamp(),
            "exp" => $future->getTimeStamp(),
            "jti" => $jti,
            'data'=> [
                'id'    => $dataUser['id'],
                'name'  => $dataUser['name'],
            ],
        ];

        $secret = $getJwtToken;
        $token = JWT::encode($payload, $secret);

        return $token;
    }

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

            $sendSms = $this->sms->to($register['phone'])
                        ->message('Please input this code for activate your account '.$register['token'].'. Expire in 5 minutes')
                        ->send();

            if (!$sendSms) {
               return $this->responseDetail("Something Wrong", 500); 
            }

            return $this->responseDetail("Register Success", 201, $register);
        }  else {
            return $this->responseDetail("Error", 400, $this->validator->errors());
        }
    }

    public function activate(Request $request, Response $response)
    {
        $rule = [
            'required' => [
                ['token'],
            ],
        ];

        $this->validator->rules($rule);

        if ($this->validator->validate()) {
            $userRepo = new \App\Repositories\UserRepository;

            $token = $request->getParam('token');

            $activate = $userRepo->activate($token);

            if (!$activate) {
                return $this->responseDetail("Token not found or expired", 400);
            }

            $this->mailer->send('templates/mailer/activate.twig', ['user' => $activate], function($message) use ($activate) {
                        $message->to($activate['email']);
                        $message->subject('Your Account is Active');
                });

            return $this->responseDetail("Your account has been activated", 200);
        } else {
            return $this->responseDetail("Error", 400, $this->validator->errors());
        }
    }

    public function resendCode(Request $request, Response $response)
    {
        $rule = [
            'required' => [
                ['username'],
            ],
        ];

        $this->validator->rules($rule);

        if ($this->validator->validate()) {
            $userRepo = new \App\Repositories\UserRepository;

            $resend = $userRepo->resendCode($request->getParam('username'));

            if (!$resend) {
                return $this->responseDetail("Wrong Username", 400);
            }

            $this->sms->to($resend['phone'])
                          ->message('Please input this code for activate your account '.$resend['token'].'. Expire in 5 minutes')
                          ->send();

            return $this->responseDetail("Success resend code", 200);
        } else {
            return $this->responseDetail("Error", 400, $this->validator->errors());
        }
    }

    public function login(Request $request, Response $response)
    {
        $userRepo = new \App\Repositories\UserRepository;

        $login = $userRepo->login($request->getParam('username'), $request->getParam('password'));

        if (!$login) {
            return $this->responseDetail("Wrong Username or Password", 401);
        }

        $login['token'] = $this->setJwt($login);

        return $this->responseDetail("Login Success", 200, $login);
    }

    public function resetPassword(Request $request, Response $response)
    {
        $userRepo = new \App\Repositories\UserRepository;

        $rule = [
            'required' => [
                ['email'],
            ],
        ];

        $this->validator->rules($rule);

        if ($this->validator->validate()) {
            $reset = $userRepo->resetPassword($request->getParam('email'));

            if (!$reset) {
                return $this->responseDetail("Email is not registered", 400);
            }

            $this->mailer->send('templates/mailer/reset_pass.twig', ['user' => $reset], function($message) use ($reset, $request) {
                        $message->to($request->getParam('email'));
                        $message->subject('Reset Your Password');
                });

            return $this->responseDetail("Reset Password Success", 201);
        } else {
            return $this->responseDetail("Error", 400, $this->validator->errors());
        }
    }

    public function getRenewPassword(Request $request, Response $response)
    {
        $userRepo = new \App\Repositories\UserRepository;

        $find = $userRepo->checkResetToken($request->getQueryParam('token'));

        if (!$find) {
            return $this->responseDetail("Token not found", 404);
        }

        return $this->responseDetail("Data Available", 200);
    }

    public function putRenewPassword(Request $request, Response $response)
    {
        $userRepo = new \App\Repositories\UserRepository;

        $rule = [
            'required' => [
                ['password'],
                ['retype_password'],
            ],
            'lengthMin' => [
                ['password', 6],
            ],
            'equals' => [
                ['retype_password', 'password']
            ],
        ];

        $this->validator->rules($rule);

        if ($this->validator->validate()) {
            $renew = $userRepo->renewPassword($request->getQueryParam('token'), $request->getParam('password'));

            if (!$renew) {
                return $this->responseDetail('Something Wrong', 400);
            }

            return $this->responseDetail('Success Renew Password', 200);
        } else {
            return $this->responseDetail('Error', 400, $this->validator->errors());
        }
    }
}
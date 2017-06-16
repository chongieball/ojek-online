<?php

namespace App\Controllers\Web;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use GuzzleHttp\Exception\BadResponseException as GuzzleException;

class UserController extends \App\Controllers\BaseController
{
	public function getRegister(Request $request, Response $response)
    {
        return $this->view->render($response, 'users/register.twig');
    }

    public function postRegister(Request $request, Response $response)
    {

    }

    public function getActivation(Request $request, Response $response)
    {
    	return $this->view->render($response, 'users/activate.twig');
    }

    public function postActivation(Request $request, Response $response)
    {

    }

    public function resendCode(Request $request, Response $response)
    {
    	
    }

    public function getResetPassword(Request $request, Response $response)
    {
    	return $this->view->render($response, 'users/reset_password.twig');
    }

    public function postResetPassword(Request $request, Response $response)
    {

    }

    public function getRenewPassword(Request $request, Response $response)
    {
    	return $this->view->render($response, 'users/renew_password.twig');
    }

    public function postRenewPassword(Request $request, Response $response)
    {
    	
    }

    public function getLogin(Request $request, Response $response)
    {
    	return $this->view->render($response, 'users/login.twig');
    }

    public function postLogin(Request $request, Response $response)
    {
    	
    }
}
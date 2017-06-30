<?php

namespace App\Controllers\Web;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AdminController extends \App\Controllers\BaseController
{
	public function home(Request $request, Response $response)
	{
		return $this->view->render($response, 'admin/home.twig');
	}
}
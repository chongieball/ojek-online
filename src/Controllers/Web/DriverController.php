<?php

namespace App\Controllers\Web;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class DriverController extends \App\Controllers\BaseController
{
	public function home(Request $request, Response $response)
	{
		echo "driver home";
	}
}
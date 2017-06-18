<?php 

namespace App\Middlewares\Api;

use App\Middlewares\BaseMiddleware;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;

class AdminMiddleware extends BaseMiddleware
{
	public function __invoke(Request $request, Response $response, $next)
	{
		$getAuth = substr($request->getHeader('Authorization')[0], 7);

		$getJwtToken = $this->container->get('settings')['jwt']['token'];

		$token = JWT::decode($getAuth, $getJwtToken, ['HS256']);

		var_dump($token->data->role_id);

		$response = $next($request, $response);
		
		return $response;
	}
}
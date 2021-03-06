<?php

namespace App\Controllers;

use Slim\Container;
use GuzzleHttp\Exception\BadResponseException as GuzzleException;

abstract class BaseController
{
	protected $container;

	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	public function __get($property)
	{
		if ($this->container->{$property}) {
			return $this->container->{$property};
		}
	}

	/**
	 * Give Description About Response
	 * @param  int|200    $status   HTTP status code
	 * @param  string     $message
	 * @param  array      $data     [description]
	 * @param  array|null $meta     additional data
	 * @return $this->response->withHeader('Content-type', 'application/json')->withJson($response, $response['status']);
	 */
	protected function responseDetail($message, $status = 200, $data = null, array $meta = null)
	{
		$response = [
			'status'	=> $status,
			'message'	=> $message,
			'data'		=> $data,
			'meta'		=> $meta,
		];

		if (is_null($data) && is_null($meta)) {
			array_pop($response);
		} if (!$meta) {
			array_pop($response);
		}

		return $this->response->withHeader('Content-type', 'application/json')->withJson($response, $response['status']);
	}

	protected function request($method, $url, $options)
	{
		try {
			$client = $this->testing->request($method, $url, $options);

			$data = json_decode($client->getBody()->getContents(), true);

		} catch (GuzzleException $e) {
			$data['errors'] = json_decode($e->getResponse()->getBody()->getContents(), true);

		}

		return $data;
	}

	protected function decodeJwt()
	{
		$getAuth = substr($this->request->getHeader('Authorization')[0], 7);

		$getJwtToken = $this->container->get('settings')['jwt']['token'];

		$token = JWT::decode($getAuth, $getJwtToken, ['HS256']);
		
		return $token;
	}
}
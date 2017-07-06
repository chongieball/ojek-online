<?php

namespace App\Controllers\Api;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\Repositories\PriceRepository;

class AdminController extends \App\Controllers\BaseController
{
	public function setPricePerKm(Request $request, Response $response)
	{
		$rules = [
			'required'	=> [
				['reg_id']
				['price'],
			],
			'numeric'	=> [
				['reg_id'],
				['price'],
			],
		];

		$this->validator->rules($rules);

		if ($this->validator->validate()) {
			$priceRepo = new PriceRepository;
			$setPrice = $priceRepo->setPrice($request->getParams());

			return $this->responseDetail('Success Update Price', 200);
		} else {
			return $this->responseDetail('Errors', 400, $this->validator->errors());
		}
	}
}
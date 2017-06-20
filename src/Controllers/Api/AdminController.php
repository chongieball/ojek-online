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
				['price'],
			],
			'numeric'	=> [
				['price'],
			],
		];

		$this->validator->rules($rules);

		if ($this->validator->validate()) {
			$priceRepo = new PriceRepository;
			$setPrice = $priceRepo->setPrice($request->getParam('price'));

			if (is_array($setPrice)) {
				return $this->responseDetail('Errors', 400, $setPrice);
			} else {
				return $this->responseDetail('Success Set Price', 201);
			}
		} else {
			return $this->responseDetail('Errors', 400, $this->validator->errors());
		}
	}
}
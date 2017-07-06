<?php 

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Repositories\FoodRepository;

class FoodController extends BaseController
{
	public function joinResto(Request $request, Response $response)
	{
		$foodRepo = new FoodRepository;

		try {
			$foodRepo->applyResto($request->getParams());

			return $this->responseDetail('Success Apply, Please wait to get acceptation from admin', 201);
		} catch (Exception $e) {
			return $this->responseDetail('Something Wrong', 500);
		}
	}

	public function editResto(Request $request, Response $response)
	{
		
	}
}
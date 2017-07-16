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

	public function showApplicantResto(Request $request, Response $response)
	{
		$foodRepo = new \App\Repositories\FoodRepository;

		$page = $request->getQueryParam('page') ? $request->getQueryParam('page') : 1;

		$showApplicant = $foodRepo->showApplicant($page, 2);
		
		if (!$showApplicant) {
			return $this->responseDetail('Applicant Restaurant is Empty', 404);
		} else {
			return $this->responseDetail('Data Available', 200, $showApplicant);
		}
	}

	public function detailApplicant(Request $request, Response $response, $args)
	{
		$foodRepo = new \App\Repositories\FoodRepository;

		$detailApplicant = $foodRepo->detailApplicant($args['id']);

		return $this->responseDetail('Data Available', 200, $detailApplicant);
	}

	public function resultApplicant(Request $request, Response $response)
	{
		$foodRepo = new \App\Repositories\FoodRepository;

		$setResult = $foodRepo->resultApplicant($request->getParams());

		$this->mailer->send('templates/mailer/result_applicant_food.twig', ['user' => $setResult], function($message) use ($setResult) {
                        $message->to($setResult['email']);
                        $message->subject('Result From Your Applicant Resto');
        });

        if ($request->getParam('status') == 1) {
        	return $this->responseDetail('Applicant has been Rejected', 200)
        } else {
        	return $this->responseDetail('Applicant has been Accepted', 201)
        }
	}
}
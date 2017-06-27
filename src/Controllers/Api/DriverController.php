<?php

namespace App\Controllers\Api;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class DriverController extends \App\Controllers\BaseController
{
	public function becomeDriver(Request $request, Response $response)
	{
		$upload = new \App\Extensions\Uploads\UploadHandler('uploads/file_drivers');

		$userId = $this->decodeJwt()->data->id;

		$rules = [
			'extension' => [
	            'allowed'   => ['jpg', 'jpeg', 'png'],
	            'message'   => '{label} must be a valid image (jpg, jpeg, png)',
	        ],
	        'size'      => [
	            'size'       => '2M',
	            'message'   => '{label} must be less than {size}',
	        ],
		];

		$upload->setRules($rules, 'File');
	    $upload->setName(uniqid());

	    $submit = $upload->upload($_FILES['file']);

	    if (key($submit) === 'errors') {
	        return $this->responseDetail('errors', 400, $submit);
	    }

	    $driverRepo = new \App\Repositories\DriverRepository;
	    $apply = $driverRepo->apply($userId, $submit);

	    if (!$apply) {
	    	return $this->responseDetail('Something Wrong', 400);
	    }

	    return $this->responseDetail('Success Apply, Please wait to get acceptation from admin', 201);
	}

	public function showApplicantDriver(Request $request, Response $response)
	{
		$driverRepo = new \App\Repositories\DriverRepository;

		$page = $request->getQueryParam('page') ? $request->getQueryParam('page') : 1;
		$showApplicant = $driverRepo->showApplicant($page, 2);

		if (!$showApplicant) {
			return $this->responseDetail('Applicant Driver is Empty', 404);
		} else {
			return $this->responseDetail('Data Available', 200, $showApplicant);
		}
	}

	public function setResultApplicantDriver(Request $request, Response $response)
	{
		$driverRepo = new \App\Repositories\DriverRepository;

		$setResult = $driverRepo->resultApplicantDriver($request->getParams());

		$this->mailer->send('templates/mailer/result_applicant_driver.twig', ['user' => $setResult], function($message) use ($setResult) {
                        $message->to($setResult['email_driver']);
                        $message->subject('Result From Your Applicant');
                });
	}
}
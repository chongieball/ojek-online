<?php 

namespace App\Models\Drivers;

use App\Models\BaseModel

class ResultApplicantDriver extends BaseModel
{
	protected $table = 'result_applicant_driver';
	protected $column = ['id', 'status', 'reason', 'create_at'];
}
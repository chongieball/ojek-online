<?php 

namespace App\Models\Drivers;

use App\Models\BaseModel

class ResultApplicantDriver extends BaseModel
{
	protected $table = 'file_applicant_driver';
	protected $column = ['result_applicant_driver', 'status', 'reason', 'create_at'];
}
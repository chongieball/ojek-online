<?php 

namespace App\Models\Drivers;

use App\Models\BaseModel;

class FileApplicantDriver extends BaseModel
{
	protected $table = 'file_applicant_driver';
	protected $column = ['app_driver_id', 'url_file'];
}
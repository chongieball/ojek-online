<?php 

namespace App\Repositories;

use App\Models\Drivers\ApplicantDriver;
use App\Models\Drivers\FileApplicantDriver;
use App\Models\Drivers\ResultApplicantDriver;

class DriverRepository extends BaseRepository
{
	public function apply($userId, $data)
	{
		$appDriver = new ApplicantDriver;
		$apply = $this->create($appDriver, ['user_id' => $userId]);

		if (!is_int($apply)) {
			return false;
		}

		$fileAppDriver = new FileApplicantDriver;
		foreach ($data as $key => $value) {
			$createData = [
				'app_driver_id' => $apply,
				'url_file'		=> $value,
			];

			$file = $this->create($fileAppDriver, $createData);

			if (!is_int($file)) {
				$error = $key;
			}
		}

		if (!$error) {
			return true;
		} else {
			$this->clear($model, $apply);
			return false;
		}
	}

	public function showApplicant($page, $limit)
	{
		$appDriver = new ApplicantDriver;
		
		return $appDriver->showApplicant($page, $limit);
	}
}
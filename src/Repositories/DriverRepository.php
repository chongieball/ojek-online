<?php 

namespace App\Repositories;

use App\Models\Drivers\ApplicantDriver;
use App\Models\Drivers\FileApplicantDriver;
use App\Models\Drivers\ResultApplicantDriver;
use App\Models\Users\UserRole;
use App\Models\Users\User;

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

	public function resultApplicantDriver($data)
	{
		$appDriver = new ApplicantDriver;
		$applicant = $this->findBy($appDriver, 'id', $data['app_driver_id']);

		$result = new ResultApplicantDriver;
		$setResult = $this->create($result, $data);
		$getResult = $this->findBy($setResult, 'id', $setResult);

		if ($data['status'] == 1) {
			$this->setToDriver($applicant['user_id']);
		}

		$dataDriver = $this->getDataDriver($applicant['user_id']);

		$getResult['email'] = $dataDriver['email'];
		$getResult['name'] = $dataDriver['name'];

		$getResult['applicant_created'] = $applicant['create_at'];

		return $getResult;
	}

	private function setToDriver($userId)
	{
		$userRole = new UserRole;
		$setDriver = $this->update($userRole, ['role_id' => 2], 'user_id', $userId);
	}

	private function getDataDriver($userId)
	{
		$user = new User;
		$findUser = $this->findBy($user, 'id', $userId);

		return $findUser
	}
}
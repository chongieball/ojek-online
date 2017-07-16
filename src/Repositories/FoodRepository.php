<?php 

namespace App\Repositories;

use App\Models\Foods\ApplicantFood;
use App\Models\Foods\ResultApplicantFood;
use App\Models\Foods\Restaurant;
use App\Models\Users\User;

class FoodRepository extends BaseRepository
{
	public function createResto($data)
	{
		$resto = new Restaurant;

		$createResto = $this->create($resto, $data);

		return $createResto;
	}

	public function applyResto($data)
	{
		$appFood = new ApplicantFood;

		$apply = $this->create($appFood, $data);
	}

	public function showApplicant($page, $limit)
	{
		$appFood = new ApplicantFood;
		
		return $appFood->showApplicant($page, $limit);
	}

	public function detailApplicant($appId)
	{
		$appFood = new ApplicantFood;

		return $this->findBy($appFood, 'id', $appId);
	}

	public function resultApplicant($data)
	{
		$resultAppFood = new ResultApplicantFood;

		$createResult = $this->create($resultAppFood, $data);

		$appFood = new ApplicantFood;

		$findApp = $this->findBy($appFood, 'id', $data['app_food_id']);

		$createResult['applicant_created'] = $findApp['created_at'];

		if ($data['status'] == 1) {
			$createResto = $this->createResto($findApp);

			$createResult['result'] = true;
		} else {
			$createResult['result'] = false;
		}

		$applicant = new User;

		$findApplicant = $this->findBy($applicant, 'id', $findApp['user_id']);

		$createResult['name'] = $findApplicant['name'];
		$createResult['email'] = $findApplicant['email'];

		return $createResult;
	}
}
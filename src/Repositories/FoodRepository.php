<?php 

namespace App\Repositories;

use App\Models\Foods\ApplicantFood;
use 

class FoodRepository extends BaseRepository
{
	public function applyResto($data)
	{
		$appFood = new ApplicantFood;

		$apply = $this->create($appFood, $data);
	}

	public function editResto($data)
	{

	}
}
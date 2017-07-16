<?php 

namespace App\Models\Foods;

use App\Models\BaseModel;

class ApplicantFood extends BaseModel
{
	protected $table = 'applicant_food';
	protected $column = ['*'];

	public function showApplicant($page, $limit)
	{	
		$qb1 = $this->getBuilder();

		$column = ['MAX(af.id)', 'MAX(af.create_at)', 'u.username', 'u.name'];

		$this->query = $qb1->select($column)
					  ->from($this->table, 'af')
					  ->leftJoin('af', 'result_applicant_food', 'raf', 'af.id = raf.app_food_id')
					  ->join('af', 'users', 'u', 'af.user_id = u.id')
					  ->where($qb1->expr()->isNull('raf.app_food_id'))
					  ->groupBy('af.user_id DESC');

		$show = $this->paginate($page, $limit);

		return $show;
	}

}
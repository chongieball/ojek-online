<?php 

namespace App\Models\Drivers;

use App\Models\BaseModel;

class ApplicantDriver extends BaseModel
{
	protected $table = 'applicant_driver';
	protected $column = ['id', 'user_id', 'create_at'];

	public function showApplicant($page, $limit)
	{	
		$qb1 = $this->getBuilder();

		$column = ['MAX(ad.id)', 'MAX(ad.create_at)', 'u.username', 'u.name'];

		$this->query = $qb1->select($column)
					  ->from($this->table, 'ad')
					  ->leftJoin('ad', 'result_applicant_driver', 'rad', 'ad.id = rad.app_driver_id')
					  ->join('ad', 'users', 'u', 'ad.user_id = u.id')
					  ->where($qb1->expr()->isNull('rad.app_driver_id'))
					  ->groupBy('ad.user_id DESC');

		$show = $this->paginate($page, $limit);

		return $show;
	}
}
<?php 

namespace App\Models\Prices;

use App\Models\BaseModel;

class Price extends BaseModel
{
	protected $table = 'price';
	protected $column = ['id', 'reg_id', 'price', 'update_at'];
}
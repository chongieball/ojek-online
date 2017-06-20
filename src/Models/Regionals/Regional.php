<?php 

namespace App\Models\Regionals;

use App\Models\BaseModel;

class Regional extends BaseModel
{
	protected $table = 'regional';
	protected $column = ['id', 'name'];
	protected $check = ['name'];
} 
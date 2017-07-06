<?php 

namespace App\Models\Foods;

use App\Models\BaseModel;

class RestaurantMenu extends BaseModel
{
	protected $table = 'menu_resto';
	protected $column = ['*'];
}
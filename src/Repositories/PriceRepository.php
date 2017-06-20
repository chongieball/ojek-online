<?php 

namespace App\Repositories;

use App\Models\Prices\Price;

class PriceRepository extends BaseRepository
{
	public function setPrice($price)
	{
		$priceModel = new Price;

		$data = [
			'price'	=> $price,
		];

		$setPrice = $priceModel->checkOrCreate($data);

		return $setPrice;
	}
}
	
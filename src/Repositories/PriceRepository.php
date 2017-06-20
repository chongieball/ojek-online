<?php 

namespace App\Repositories;

use App\Models\Prices\Price;

class PriceRepository extends BaseRepository
{
	public function setPrice($data)
	{
		$priceModel = new Price;

		$update = [
			'price'	=> $data['price'],
		];

		$this->update($model, $update, 'id', $data['id']);
	}
}
	
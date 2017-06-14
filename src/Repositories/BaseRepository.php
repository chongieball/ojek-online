<?php 

namespace App\Repositories;

use App\Repositories\Contracts\RepositoriesInterface;
use App\Models\BaseModel;

abstract class BaseRepository implements RepositoriesInterface
{

	protected function checkModel($model)
	{
		if (!$model instanceof BaseModel) {
			throw new \Exception("Model must be an instance of BaseModel");
		}

		return $model;
	}

	public function getAll($model)
	{
		$model = $this->checkModel($model);

		$result = $model->getAll()->fetchAll();

		return $result;
	}

	public function create($model, array $data)
	{
		$model = $this->checkModel($model);

		$result = $model->create($data);

		return $result;
	}

	public function update($model, array $data, $column, $value)
	{
		$model = $this->checkModel($model);

		$result = $model->update($data, $column, $value);

		return $result;
	}

	public function findBy($model, $column, $value, $operator = '=', $fetchAll = false, $deleted = null)
	{
		$model = $this->checkModel($model);

		$query = $model->find($column, $value, $operator);

		if ($deleted === false) {
			$query = $query->withoutDelete();
		} elseif ($deleted === true) {
			$query = $query->withDelete();
		}

		if ($fetchAll === false ) {
			$result = $query->fetch();
		} else {
			$result = $query->fetchAll();
		}

		return $result;
	}

	public function delete($model, $column, $value, $name = 'soft')
	{
		$model = $this->checkModel($model);

		$delete = $name.'Delete';

		$model->$delete($column, $value);
	}
}
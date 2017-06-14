<?php 

namespace App\Repositories\Contracts;

interface RepositoriesInterface
{
	public function getAll($model);
	public function create($model, array $data);
	public function update($model, array $data, $column, $value);
	public function findBy($model, $column, $value, $operator = '=', $fetchAll = false, $deleted = null);
	public function delete($model, $column, $value, $name = 'soft');
}
<?php 

namespace App\Repositories\Contracts;

interface RepositoriesInterface
{
	public function getAll();
	public function create(array $data);
	public function update(array $data, $column = null, $value = null);
	public function findBy($column, $value = null, $operator = '=');
	public function delete($column, $value, $name = 'soft');
}
<?php 

namespace App\Repositories;

use App\Models\Users\User;
use App\Models\Users\UserRole;
use App\Models\Users\ActivateUser;

class UserRepository extends BaseRepository
{
	public function register(array $data)
	{
		$user = new User;
		$register = $user->register($data);

		if (is_int($register)) {
			$role = new UserRole;
			$role->createRole($register);

			$activate = new ActivateUser;
			$activate->createToken($register);

			$findUser = $this->findBy($user, 'id', $register);
			$findUser['token'] = $this->findBy($activate, 'user_id', $register)['token'];

			return $findUser;
		}

		foreach ($register as $key => $value) {
			$error['errors'][] = $value.' has already used';
		}

		return $error;
	}

	public function activate($token)
	{
		$activate = new ActivateUser;

		$find = $this->findBy($activate, 'token', $token);

		if (!$find) {
			return false;
		}

		$activate->delete($activate, 'token', $token, $name = 'hard');

		return true;
	}
}
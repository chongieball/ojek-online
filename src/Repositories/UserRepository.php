<?php 

namespace App\Repositories;

use App\Models\Users\User;
use App\Models\Users\UserRole;
use App\Models\Users\ActivateUser;
use App\Models\Users\ResetPassword;

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

		if (!$find || $find['expire_at'] < date('Y-m-d H:i:s')) {
			return false;
		}

		$user = new User;

		$data = [
			'is_active'	=> 1,
		];

		$this->update($user, $data, 'id', $find['user_id']);

		$findUser = $this->findBy($user, 'id', $find['user_id']);

		$this->delete($activate, 'token', $token, $name = 'hard');

		return $findUser;
	}

	private function findUser($column, $value)
	{
		$user = new User;

		$findUser = $this->findBy($user, $column, $value);

		if (!$findUser) {
			return false;
		}

		return $findUser;
	}

	public function resendCode($username)
	{
		$findUser = $this->findUser('username', $username);
		if (!$findUser) {
			return false;
		}

		$activate = new ActivateUser;

		$data = [
			'token'		=> substr(md5(openssl_random_pseudo_bytes(12)), 9, 4),
			'expire_at'	=> date('Y-m-d H:i:s', strtotime('+10 minutes')),
		];

		$this->update($activate, $data, 'user_id', $findUser['id']);

		return $findUser;
	}

	public function login($username, $password)
	{
		$findUser = $this->findUser('username', $username);

		if (!$findUser || !password_verify($password, $findUser['password'])) {
			return false;
		}

		$role = new UserRole;

		$findUser['role'] = $this->findBy($role, 'user_id', $findUser['id'])['role_id'];

		return $findUser;
	}

	public function resetPassword($email)
	{
		$findUser = $this->findUser('email', $email);
		if (!$findUser) {
			return false;
		}

		$reset = new ResetPassword;

		$resetPass = $reset->resetPass($findUser['id']);

		$findUser['token'] = $this->findBy($reset, 'user_id', $findUser['id'])['token'];

		return $findUser;
	}

	public function checkResetToken($token)
	{
		$reset = new ResetPassword;

		$find = $this->findBy($reset, 'token', $token);

		if (!$find || $find['expire_at'] < date('Y-m-d H:i:s')) {
			return false;
		}

		return $find;
	}

	public function renewPassword($token, $password)
	{
		$reset = new ResetPassword;

		$check = $this->checkResetToken($token);

		if (!$check) {
			return false;
		}

		$user = new User;

		$data = [
			'password'	=> password_hash($password, PASSWORD_DEFAULT),
		];

		$this->update($user, $data, 'id', $check['user_id']);

		$this->delete($reset, 'user_id', $check['user_id'], $name = 'hard');

		return true;
	}
}
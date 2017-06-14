<?php 

namespace App\Models\Users;

use App\Models\BaseModel;

class ResetPassword extends BaseModel
{
	protected $table = 'password_reset';
    protected $column = ['user_id', 'token', 'expire_at'];
    protected $check = ['user_id'];

    public function resetPass($userId)
    {
        $data = [
            'user_id'   => $userId,
            'token'     => md5(openssl_random_pseudo_bytes(12)),
            'expire_at'	=> date('Y-m-d H:i:s', strtotime('+1 day')),
        ];

        return $this->updateOrCreate($data);
    }
}
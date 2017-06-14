<?php 

namespace App\Models\Users;

class ActivateUser extends \App\Models\BaseModel
{
    protected $table = 'user_activate_token';
    protected $column = ['user_id', 'token', 'expire_at'];

    public function createToken($userId)
    {
    	$data = [
    		'user_id'	=> $userId,
    		'token'		=> substr(md5(openssl_random_pseudo_bytes(12)), 9, 4),
    		'expire_at'	=> date('Y-m-d H:i:s', strtotime('+2 day')),
    	];

    	$this->create($data);
    }
}
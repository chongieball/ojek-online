<?php

use Phinx\Seed\AbstractSeed;

class AaUserSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'username'      => 'superadmin',
                'email'         => 'superadmin@mail.com',
                'password'      => password_hash('superadmin', PASSWORD_DEFAULT),
                'name'          => 'Super Admin',
                'phone'         => '081278862488',
                'is_active'     => 1
            ],
            [
                'username'  => 'driver1',
                'email'     => 'driver1@mail.com',
                'password'  => password_hash('driver1', PASSWORD_DEFAULT),
                'name'      => 'Driver 1',
                'phone'     => '081278862488',
                'is_active' => 1
            ],
            [
                'username'  => 'driver2',
                'email'     => 'driver2@mail.com',
                'password'  => password_hash('driver2', PASSWORD_DEFAULT),
                'name'      => 'Driver 2',
                'phone'     => '081278862488',
                'is_active' => 1
            ],
            [
                'username'  => 'member1',
                'email'     => 'member1@mail.com',
                'password'  => password_hash('member1', PASSWORD_DEFAULT),
                'name'      => 'Member 1',
                'phone'     => '081278862488',
                'is_active' => 1
            ],
            [
                'username'  => 'member2',
                'email'     => 'member2@mail.com',
                'password'  => password_hash('member2', PASSWORD_DEFAULT),
                'name'      => 'Member 2',
                'phone'     => '081278862488',
                'is_active' => 1
            ],
        ];
        $posts = $this->table('users');
        $posts->insert($data)
              ->save();
    }
}

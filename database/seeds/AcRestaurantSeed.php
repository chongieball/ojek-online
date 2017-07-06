<?php

use Phinx\Seed\AbstractSeed;

class AcRestaurantSeed extends AbstractSeed
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
        $data[] = [
            'user_id'   => 4,
            'name'      => 'Resto Member 1',
            'address'   => 'Jl. Depokan 2 Rejowinangun',
            'phone'     => '081312312312',
        ];
        $data[] = [
            'user_id'   => 5,
            'name'      => 'Resto Member 2',
            'address'   => 'Jl. Nyi Ageng Nis',
            'phone'     => '081312312313',
        ];

        $resto = $this->table('restaurant');
        $resto->insert($data)
              ->save();
    }
}

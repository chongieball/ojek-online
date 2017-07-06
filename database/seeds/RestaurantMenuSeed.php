<?php

use Phinx\Seed\AbstractSeed;

class RestaurantMenuSeed extends AbstractSeed
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
            'resto_id'  => 1,
            'name'      => 'Menu Resto 1-1',
            'price'     => 13000,
        ];

        $data[] = [
            'resto_id'  => 1,
            'name'      => 'Menu Resto 1-2',
            'price'     => 14000,
        ];

        $data[] = [
            'resto_id'  => 2,
            'name'      => 'Menu Resto 2-1',
            'price'     => 20000,
        ];

        $resto = $this->table('menu_resto');
        $resto->insert($data)
              ->save();
    }
}

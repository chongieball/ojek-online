<?php

use Phinx\Seed\AbstractSeed;

class PriceSeed extends AbstractSeed
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
            'reg_id'    => 1,
            'price'     => 4000.
        ];
        $data[] = [
            'reg_id'    => 2,
            'price'     => 3000.
        ];
        $data[] = [
            'reg_id'    => 3,
            'price'     => 2000.
        ];
    }
}

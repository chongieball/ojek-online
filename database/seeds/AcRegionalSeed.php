<?php

use Phinx\Seed\AbstractSeed;

class AcRegionalSeed extends AbstractSeed
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
            ['name' => 'Jakarta'],
            ['name' => 'Bengkulu'],
            ['name' => 'D.I Yogyakarta']
        ];

        $this->insert('regional', $data);
    }
}

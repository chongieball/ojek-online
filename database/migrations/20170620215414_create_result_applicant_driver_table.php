<?php

use Phinx\Migration\AbstractMigration;

class CreateResultApplicantDriverTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $result = $this->table('result_applicant_driver');
        $result->addColumn('app_driver_id', 'integer')
            ->addColumn('status', 'integer')
            ->addColumn('reason', 'text', ['null' => true])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('app_driver_id', 'applicant_driver', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->create();
    }
}

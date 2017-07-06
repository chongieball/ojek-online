<?php

use Phinx\Migration\AbstractMigration;

class CreateFileApplicantDriverTable extends AbstractMigration
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
        $fileDriver = $this->table('file_applicant_driver', ['id' => false]);
        $fileDriver->addColumn('app_driver_id', 'integer')
                   ->addColumn('url_file', 'string')
                   ->addForeignKey('app_driver_id', 'applicant_driver', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
                   ->create();
    }
}

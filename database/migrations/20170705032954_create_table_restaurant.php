<?php

use Phinx\Migration\AbstractMigration;

class CreateTableRestaurant extends AbstractMigration
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
        $resto = $this->table('restaurant');
        $resto->addColumn('user_id', 'integer')
              ->addColumn('name', 'string')
              ->addColumn('address', 'text')
              ->addColumn('phone', 'string')
              ->addColumn('photo', 'text', ['default' => 'http://vectorpage.com/uploads/2013/09/Cartoon-restaurant-vector-6.jpg', 'null' => true])
              ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('update_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
              ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
              ->create();
    }
}

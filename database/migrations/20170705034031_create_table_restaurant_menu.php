<?php

use Phinx\Migration\AbstractMigration;

class CreateTableRestaurantMenu extends AbstractMigration
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
        $menu = $this->table('menu_resto');
        $menu->addColumn('resto_id', 'integer')
             ->addColumn('name', 'string')
             ->addColumn('price', 'integer')
             ->addColumn('photo', 'text', ['default' => 'https://maxcdn.icons8.com/Share/icon/color/City//restaurant_menu1600.png'])
             ->addColumn('deleted', 'integer', ['default' => 0])
             ->addForeignKey('resto_id', 'restaurant', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
             ->create();
    }
}

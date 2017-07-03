<?php

use Phinx\Migration\AbstractMigration;

class TestDb extends AbstractMigration
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
        $this->table('test', ['engine' => 'InnoDB', 'primary_key' => ['id']])
            ->addColumn('name', 'string', ['limit' => '32', 'default' => ''])
            ->addColumn('age', 'integer', ['limit' => 10, 'default' => 0])
            ->create();
    }
}

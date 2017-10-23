<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Room extends AbstractMigration
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
        $this->table('room')
            ->addColumn('roomNo', 'string', ['limit' => 16, 'default' => '', 'comment' => '房间编号'])
            ->addColumn('masterId', 'integer', ['comment' => '房间主人id'])
            ->addColumn('type', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 0, 'comment' => '房间所属分区类型'])
            ->addColumn('secret', 'boolean', ['default' => 0, 'comment' => '房间是否加密'])
            ->addColumn('password', 'string', ['limit' => 16, 'default' => 0, 'comment' => '房间密码'])
            ->addColumn('subject', 'string', ['limit' => 128, 'default' => '未命名的海景房', 'comment' => '房间标题'])
            ->addColumn('description', 'text', ['limit' => 255, 'comment' => '房间简介'])
            ->addColumn('createdTime', 'timestamp', ['comment' => '创建时间'])
            ->addColumn('updatedTime', 'timestamp', ['comment' => '更新时间'])
            ->addIndex(['type', 'masterId', 'roomNo'])
            ->create();
    }
}

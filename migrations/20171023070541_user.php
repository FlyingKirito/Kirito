<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class User extends AbstractMigration
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
        $this->table('user')
            ->addColumn('username', 'string', ['limit' => 32, 'comment' => '用户名'])
            ->addColumn('password', 'char', ['limit' => 32, 'default' => '', 'comment' => '密码'])
            ->addColumn('salt', 'char', ['limit' => 32, 'default' => '', 'comment' => '加密盐'])
            ->addColumn('niackname', 'string', ['limit' => 32, 'comment' => '昵称'])
            ->addColumn('avatar', 'string', ['limit' => 255, 'default' => 'http://www.shagua.com/2B.jpg', 'comment' => '头像'])
            ->addColumn('level', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 1, 'comment' => '等级'])
            ->addColumn('live', 'boolean', ['default' => 0, 'comment' => '是否开启直播功能'])
            ->addColumn('description', 'text', ['comment' => '描述'])
            ->addColumn('createdTime', 'timestamp', ['comment' => '创建时间'])
            ->addColumn('updatedTime', 'timestamp', ['comment' => '更新时间'])
            ->addIndex(['username'])
            ->create();
    }
}

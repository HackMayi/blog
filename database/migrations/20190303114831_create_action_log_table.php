<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateActionLogTable extends Migrator
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
        $table = $this->table('action_log')->setId('id');
        $table->addColumn('title','string',array('limit'=>255,'default'=>'','comment'=>'标题'))
              ->addColumn('uid','integer',array('limit'=>11,'comment'=>'操作的用户ID'))
              ->addColumn('url','string',array('limit'=>255,'default'=>'','comment'=>'操作的连接地址'))
              ->addColumn('log_ip','integer',array('limit'=>11,'default'=>0,'comment'=>'操作IP'))
              ->addColumn('log_at','integer',array('limit'=>11,'default'=>0,'comment'=>'操作时间'))
              ->create();
    }
}

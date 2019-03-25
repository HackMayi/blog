<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateBlogCounterLogTable extends Migrator
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
        $this->table('blog_counter_log')->setId(false)
             ->addColumn('date_time','date',array('default'=>'0000-00-00','comment'=>'日期'))
             ->addColumn('today','integer',array('limit'=>11,'default'=>0,'comment'=>'今日访问量'))
             ->addColumn('create_at','integer',array('limit'=>11,'default'=>0,'comment'=>'创建时间'))
             ->create();
    }
}

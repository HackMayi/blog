<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateBlogFriendTable extends Migrator
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
        $table = $this->table('blog_friend')->setId('id');
        $table->addColumn('web_name','string',array('limit'=>255,'default'=>'','comment'=>'网站名称'))
              ->addColumn('jump_url','string',array('limit'=>255,'default'=>'','comment'=>'网站跳转地址'))
              ->addColumn('sort','integer',array('limit'=>11,'default'=>0,'comment'=>'权重'))
              ->addColumn('go_number','integer',array('limit'=>11,'default'=>0,'comment'=>'点击流量'))
              ->addColumn('create_at','integer',array('limit'=>11,'default'=>0,'comment'=>'创建时间'))
              ->create();
    }
}
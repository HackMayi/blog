<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateBlogNoticeTable extends Migrator
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
        $table = $this->table('blog_notice')->setId('id');
        $table -> addColumn('cover','string',array('limit'=>255,'default'=>'','comment'=>'封面'))
               -> addColumn('path','string',array('limit'=>255,'default'=>'','comment'=>'路径'))
               -> addColumn('content','text',array('comment'=>'内容'))
               ->addColumn('create_at','integer',array('limit'=>11,'default'=>0,'comment'=>'发布时间'))
               ->create();
    }
}

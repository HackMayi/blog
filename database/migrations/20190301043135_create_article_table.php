<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateArticleTable extends Migrator
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
        $table = $this->table('blog_article')->setId('id');
        $table ->addColumn('cate_id','integer',array('limit'=>10,'default'=>0,'comment'=>'分类ID'))
               ->addColumn('title','string',array('limit'=>255,'comment'=>'文字标题'))
               ->addColumn('intro','string',array('limit'=>255,'default'=>'','comment'=>'文章描述'))
               ->addColumn('cover','string',array('limit'=>255,'default'=>'','comment'=>'文章封面'))
               ->addColumn('path','string',array('limit'=>255,'default'=>'','comment'=>'路径'))
               ->addColumn('status','boolean',array('limit'=>1,'default'=>1,'comment'=>'文章状态 0隐藏 1显示'))
               ->addColumn('content','text',array('comment'=>'文章内容'))
               ->addColumn('read_number','integer',array('limit'=>11,'default'=>0,'comment'=>'文章阅读量'))
               ->addColumn('sort','integer',array('limit'=>11,'default'=>0,'comment'=>'权重'))
               ->addColumn('create_at','integer',array('limit'=>11,'default'=>0,'comment'=>'创建时间'))
               ->addColumn('update_at','integer',array('limit'=>11,'default'=>0,'comment'=>'修改时间'))
               ->create();
    }
}

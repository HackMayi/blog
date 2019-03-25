<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateBlogCateTable extends Migrator
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
        $table = $this->table('blog_cate')->setId('id');
        $table ->addColumn('cate_name','string',array('limit'=>100,'comment'=>'分类名称'))
               ->addColumn('cate_type','integer',array('limit'=>5,'default'=>0,'comment'=>'分类标志 0推荐 1热门'))
               ->addColumn('status','integer',array('limit'=>5,'default'=>1,'comment'=>'分类状态 0隐藏 1显示'))
               ->addColumn('describe','string',array('limit'=>255,'default'=>'','comment'=>'分类描述'))
               ->addColumn('click_sum','integer',array('limit'=>11,'default'=>0,'comment'=>'分类点击量'))
               ->addColumn('create_at','integer',array('limit'=>11,'default'=>0,'comment'=>'分类创建时间'))
               ->addColumn('parent_id','integer',array('limit'=>11,'default'=>0,'comment'=>'上级分类'))
               ->create();
    }
}

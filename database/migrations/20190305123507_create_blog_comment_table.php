<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateBlogCommentTable extends Migrator
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
        $table = $this->table('blog_comment')->setId('id');
        $table -> addColumn('article_id','integer',array('limit'=>11,'default'=>0,'comment'=>'新闻id'))
               -> addColumn('nickname','string',array('limit'=>255,'default'=>'','comment'=>'昵称'))
               -> addColumn('email','string',array('limit'=>255,'default'=>'','comment'=>'邮箱'))
               -> addColumn('web_url','string',array('limit'=>255,'default'=>'','comment'=>'网址'))
               -> addColumn('content','text',array('comment'=>'评论/留言内容'))
               -> addColumn('status','boolean',array('limit'=>1,'default'=>0,'comment'=>'状态 0隐藏 1显示 2已回复'))
               -> addColumn('create_at','integer',array('limit'=>11,'default'=>0,'comment'=>'创建时间'))
               -> addColumn('update_at','integer',array('limit'=>11,'default'=>0,'comment'=>'修改时间'))
               -> create();
    }
}

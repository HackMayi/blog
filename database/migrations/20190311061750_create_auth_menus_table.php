<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateAuthMenusTable extends Migrator
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
        $this-> table('auth_menus')->setId('id')
             -> addColumn('name','string',array('limit'=>255,'default'=>'','comment'=>'路由地址'))
             -> addColumn('description','string',array('limit'=>255,'default'=>'','comment'=>'描述'))
             -> addColumn('create_at','integer',array('limit'=>11,'default'=>0,'comment'=>'创建时间'))
             -> addColumn('update_at','integer',array('limit'=>11,'default'=>0,'comment'=>'修改时间'))
             -> addIndex('name')
             -> create();
        $sql = "insert  into `auth_menus`(`id`,`name`,`description`,`create_at`,`update_at`) values (1,'admin/menu/index','菜单管理',1552361569,0),(2,'admin/setting/index','基本设置',1552361689,0),(3,'admin/user/lists','管理列表',1552361747,0),(4,'admin/authority/role','角色管理',1552361818,0),(5,'blog/cate/index','分类管理',1552361957,0),(6,'blog/article/index','文章管理',1552362273,0),(7,'blog/friend/index','友链管理',1552362340,0),(8,'blog/notice/index','博客历程',1552362366,0)";
        $this->execute($sql);
    }
}

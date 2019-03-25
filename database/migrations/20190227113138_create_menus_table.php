<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateMenusTable extends Migrator
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
        $table = $this->table('menus')->setId('id');
        $table ->addColumn('parent_id','integer',array('limit'=>11,'default'=>0,'comment'=>'上级分类'))
               ->addColumn('name','string',array('limit'=>100,'comment'=>'菜单名称'))
               ->addColumn('module','string',array('limit'=>100,'default'=>'','comment'=>'模块'))
               ->addColumn('controller','string',array('limit'=>100,'default'=>'','comment'=>'控制器'))
               ->addColumn('method','string',array('limit'=>100,'default'=>'','comment'=>'方法'))
               ->addColumn('icon','string',array('limit'=>255,'default'=>'','comment'=>'图标'))
               ->addColumn('auth_menu','boolean',array('limit'=>1,'default'=>0,'comment'=>'菜单类型 1权限菜单0普通菜单'))
               ->addColumn('rule_param','integer',array('limit'=>11,'default'=>0,'comment'=>'规则ID'))
               ->addColumn('status','boolean',array('limit'=>1,'default'=>0,'comment'=>'菜单状态 1展示左侧菜单栏 0作为普通节点'))
               ->create();


        $sql = "insert  into `menus`(`id`,`parent_id`,`name`,`module`,`controller`,`method`,`icon`,`auth_menu`,`rule_param`,`status`) values (1,0,'系统配置','','','','&#xe696;',0,0,1),(2,1,'权限管理','','','','',0,0,1),(3,2,'菜单管理','admin','menu','index','',1,1,1),(4,1,'网站配置','','','','',0,0,1),(5,4,'基本设置','admin','setting','index','',1,2,1),(6,2,'管理列表','admin','user','lists','',1,3,1),(7,2,'角色管理','admin','authority','role','',1,4,1),(8,0,'博客管理','','','','&#xe699;',0,0,1),(9,8,'分类管理','blog','cate','index','',1,5,1),(10,8,'文章管理','blog','article','index','',1,6,1),(11,8,'友链管理','blog','friend','index','',1,7,1),(12,8,'博客历程','blog','notice','index','',1,8,1)";
        $this->execute($sql);
    }
}

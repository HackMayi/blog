<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateAuthRuleTable extends Migrator
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
        $this->table('auth_rule')
             ->addColumn('role_id','integer',array('limit'=>11,'comment'=>'角色id'))
             ->addColumn('child','string',array('limit'=>255,'comment'=>'节点'))
             ->create();
        $sql = <<<INFO
insert  into `auth_rule`(`role_id`,`child`) values (1,'a:8:{i:0;s:20:\"admin/authority/role\";i:1;s:16:\"admin/menu/index\";i:2;s:19:\"admin/setting/index\";i:3;s:16:\"admin/user/lists\";i:4;s:18:\"blog/article/index\";i:5;s:15:\"blog/cate/index\";i:6;s:17:\"blog/friend/index\";i:7;s:17:\"blog/notice/index\";}');
INFO;
        $this->execute($sql);
    }
}

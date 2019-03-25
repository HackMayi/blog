<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateAuthRoleTable extends Migrator
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
        $table = $this->table('auth_role')->setId('id');
        $table -> addColumn('name','string',array('limit'=>255,'default'=>'','comment'=>'角色名称'))
               -> addColumn('remark','string',array('limit'=>255,'default'=>'','comment'=>'备注'))
               -> addColumn('create_at','integer',array('limit'=>11,'default'=>0,'comment'=>'创建时间'))
               -> addColumn('update_at','integer',array('limit'=>11,'default'=>0,'comment'=>'修改时间'))
               ->addIndex('name')
               ->create();

        $sql = "insert  into `auth_role`(`id`,`name`,`remark`,`create_at`,`update_at`) values (1,'超管','',1552362866,0)";
        $this->execute($sql);
    }
}

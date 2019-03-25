<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateAdminTable extends Migrator
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
        $table = $this->table('admin')->setId('id');
        $table->addColumn('uname','string',array('limit' => 32,'comment'=>'用户名'))
              ->addColumn('password','string',array('limit' => 64,'default'=>md5('123456'),'comment'=>'密码'))
              ->addColumn('email','string',array('limit' => 64,'default'=>'','comment'=>'邮箱'))
              ->addColumn('last_login_time','integer',array('limit'=>11,'default'=>0,'comment'=>'最后登录时间'))
              ->addColumn('last_login_ip','integer',array('limit'=>11,'default'=>0,'comment'=>'最后登录IP'))
              ->addColumn('status','boolean',array('limit' => 1,'default'=>0,'comment'=>'状态，1禁止登录'))
              ->addColumn('create_at','integer',array('limit'=>11,'default'=>0,'comment'=>'创建时间'))
              ->addColumn('update_at','integer',array('limit'=>11,'default'=>0,'comment'=>'修改时间'))
              ->addIndex(array('uname'),array('unique' => true))
              ->create();

        $sql = "insert  into `admin`(`id`,`uname`,`password`,`last_login_time`,`last_login_ip`,`status`,`create_at`,`update_at`,`email`) values (1,'admin','e10adc3949ba59abbe56e057f20f883e',0,0,0,0,0,'')";
        $this->execute($sql);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/27
 * Time: 19:38
 */

namespace app\admin\validate;


use think\Validate;

class MenusValidate extends Validate
{
    protected $rule = [
        'parent_id'     => 'require'
        ,'name'         => 'require'
        ,'id'           => 'require'
        ,'auth_menu'    => 'require'
        ,'status'    => 'require'
    ];

    //定义验证提示
    protected $message = [
        'parent_id.require'     => '上级分类不能为空'
        ,'name.require'  => '菜单名称不能为空'
        ,'id.require'    => '缺少条件'
        ,'auth_menu.require' => '类型不能为空'
        ,'status.require' => '状态不能为空'
    ];

    protected $scene = [
        'add'   =>  ['parent_id','name','auth_menu','status'],
        'edit'  =>  ['parent_id','name','id','auth_menu','status'],
    ];
}
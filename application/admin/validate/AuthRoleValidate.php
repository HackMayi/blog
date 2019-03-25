<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/11
 * Time: 17:53
 */

namespace app\admin\validate;


use think\Validate;

class AuthRoleValidate extends Validate
{
    protected $rule = [
        'name'             => 'require|unique:auth_role',
    ];

    //定义验证提示
    protected $message = [
        'name.require'     => '角色名称不能为空'
        ,'name.unique'     => '角色名称已存在'
    ];
}
<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/27
 * Time: 16:27
 */
namespace app\admin\validate;

use think\Validate;

class AdminValidate extends Validate
{
    protected $rule = [
        'uname'             => 'require|unique:admin',
        'password'          => 'require',
        'email'             => 'require',
    ];

    //定义验证提示
    protected $message = [
        'uname.require'      => '用户名不能为空'
        ,'password.require'  => '密码不能为空'
        ,'email.require'     => '邮箱不能为空'
        ,'uname.unique'      => '用户名已存在'
    ];

    protected $scene = [
        'login'   =>  ['uname.require','password']
        ,'edit'   =>  ['email']
        ,'add'    =>  ['uname']
    ];
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/3
 * Time: 21:05
 */

namespace app\blog\validate;


use think\Validate;

class BlogFriendValidate extends Validate
{
    protected $rule = [
        'web_name'     => 'require',
        'jump_url'     => 'require',
    ];

    protected $message = [
        'web_name.require'     => '网站名称不能为空',
        'jump_url.require'     => '跳转地址不能为空',
    ];
}
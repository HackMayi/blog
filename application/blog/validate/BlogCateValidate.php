<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/28
 * Time: 22:56
 */

namespace app\blog\validate;


use think\Validate;

class BlogCateValidate extends Validate
{
    protected $rule = [
        'cate_name'     => 'require',
        'cate_type'     => 'require',
        'status'        => 'require',
        'parent_id'     => 'require'
    ];

    //定义验证提示
    protected $message = [
        'cate_name.require'     => '分类名称不能为空',
        'cate_type.require'     => '分类标志不能为空',
        'status.require'        => '分类状态不能为空',
        'parent_id.require'     => '缺少分类条件'
    ];

    protected $scene = [
        'add'   =>  ['cate_name','cate_type','status'],
    ];
}
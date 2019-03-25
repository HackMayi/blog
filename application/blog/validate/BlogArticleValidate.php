<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/1
 * Time: 19:06
 */

namespace app\blog\validate;


use think\Validate;

class BlogArticleValidate extends Validate
{
    protected $rule = [
        'cate_id'     => 'require',
        'title'       => 'require',
        'status'      => 'require',
        'content'     => 'require'
    ];

    //定义验证提示
    protected $message = [
        'cate_id.require'     => '分类不能为空',
        'title.require'       => '文章标题不能为空',
        'status.require'      => '文章状态不能为空',
        'content.require'     => '文章内容不能为空'
    ];

    protected $scene = [
        'add'   =>  ['cate_id','title','status','content'],
    ];
}
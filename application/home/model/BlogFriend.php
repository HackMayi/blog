<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/5
 * Time: 20:23
 */

namespace app\home\model;


use think\Model;

class BlogFriend extends Model
{
    public static function getList()
    {
        return self::order('sort','desc')->paginate(10);
    }
}
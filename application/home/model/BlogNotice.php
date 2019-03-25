<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/8
 * Time: 20:46
 */

namespace app\home\model;


use think\Model;

class BlogNotice extends Model
{
    public static function getList($sum = 10,$orderFiled = 'create_at',$type = 'desc')
    {
        $result = self::order($orderFiled,$type)->paginate($sum);
        return array('list'=>$result,'page'=>$result->render());
    }
}
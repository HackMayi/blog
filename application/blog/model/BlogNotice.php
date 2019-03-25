<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/8
 * Time: 20:06
 */

namespace app\blog\model;


use think\Model;

class BlogNotice extends Model
{
    protected $createTime = 'create_at';
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    public static function getList($where = array(),$orderFiled = 'create_at',$type = 'desc',$sum = 10)
    {
        $result = self::where($where)->order($orderFiled,$type)->paginate($sum);
        return array('list'=>$result,'page'=>$result->render());
    }
}
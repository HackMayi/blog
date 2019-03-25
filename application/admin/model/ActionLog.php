<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/3
 * Time: 19:53
 */

namespace app\admin\model;


use think\Model;

class ActionLog extends Model
{
    public static function addLog($param = array())
    {
        if (self::insert($param)) {
            return true;
        } else {
            return false;
        }
    }

    public static function getUserLog($uid)
    {
        $result = self::where('uid',$uid)->paginate(10);
        $page   = $result->render();
        return array('list'=>$result,'page',$page);
    }
}
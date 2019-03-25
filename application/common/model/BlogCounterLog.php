<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/25
 * Time: 11:31
 */

namespace app\common\model;


use think\Model;

class BlogCounterLog extends Model
{
    protected $createTime = 'create_at';
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    public static function getTime($where)
    {
        self::where($where)->find();
    }
}
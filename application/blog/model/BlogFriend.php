<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/3
 * Time: 21:08
 */

namespace app\blog\model;


use think\Model;

class BlogFriend extends Model
{
    protected $createTime = 'create_at';
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    public static function getLists()
    {
        $data = self::order('sort','desc')->paginate(10);
        $page = $data->render();
        return array('list'=>$data,'page'=>$page);
    }
}
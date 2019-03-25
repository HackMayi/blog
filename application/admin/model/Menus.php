<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/27
 * Time: 19:37
 */

namespace app\admin\model;


use think\Model;

class Menus extends Model
{
    public static function getMenus($where = array())
    {
        $menus = model('menus')->where($where)->select();
        return self::disposeData($menus);
    }

    public static function disposeData($menus,$pid = 0, $level = 0)
    {
        static $menu = array();
        if (empty($menus)) return $menu;
        foreach ($menus as $value) {
            if ($value['parent_id'] == $pid) {
                $value['level'] = $level+1;
                if($level == 0) {
                    $value['str'] = str_repeat('',$value['level']);
                } elseif($level == 2) {
                    $value['str'] = '&emsp;&emsp;&emsp;&emsp;'.'|- ';
                } elseif($level == 3) {
                    $value['str'] = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;'.'|- ';
                } else {
                    $value['str'] = '&emsp;&emsp;'.'|- ';
                }
                $menu[] = $value;
                self::disposeData($menus,$value['id'],$value['level']);
            }
        }
        return $menu;
    }

    public static function getRuleParam($id,$field)
    {
        return self::where(array('id'=>$id))->field($field)->find();
    }
}
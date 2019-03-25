<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/7
 * Time: 20:14
 */

namespace app\admin\model;


use think\Model;

class WebSetting extends Model
{
    public function settingData($param = array())
    {
        return $this->save($param);
    }
}
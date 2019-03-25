<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/28
 * Time: 13:31
 */

namespace app\admin\controller;


use app\admin\service\SettingService;
use app\common\controller\Common;
use think\Exception;

class Setting extends Common
{
    public function index()
    {
        return $this->fetch();
    }

    public function set()
    {
        if ($this->request->isAjax()) {
            try{
                $param = $this->request->param();
                switch ($param['genre']) {
                    case 'admin':
                        SettingService::checkFile($param,SettingService::$path);
                        break;
                    case 'blog':
                        SettingService::checkFile($param,SettingService::$blog_path);
                }
            } catch (Exception $e) {
                return json(array('code'=>0,'msg'=>$e->getMessage()));
            }
            return json(array('code'=>1,'msg'=>'设置成功'));
        } else {
            return json(array('code'=>0,'msg'=>'请求方式错误'));
        }
    }
}
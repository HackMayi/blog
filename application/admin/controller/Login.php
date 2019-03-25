<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/27
 * Time: 15:19
 */

namespace app\admin\controller;


use app\admin\model\ActionLog;
use app\admin\model\Admin;
use think\Controller;
use think\Exception;
use think\Session;

class Login extends Controller
{
    public function login()
    {
        if ($this->request->isPost()) {
            try{
                $param = $this->request->param();
                $model = new Admin();
                $model->checkLogin($param);
                # 记录日志
                $arr['title'] = '后台登录';
                $arr['url']   = $this->request->url();
                $arr['uid']   = Session::get('uid');
                $arr['log_ip']= ip2long($this->request->ip());
                $arr['log_at']= time();
                ActionLog::addLog($arr);

            }catch (Exception $e) {
                return json(array('code'=>0,'msg'=>$e->getMessage()));
            }
            return json(array('code'=>1,'msg'=>'登录成功'));
        }
        return $this->fetch();
    }
}
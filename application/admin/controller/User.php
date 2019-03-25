<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/28
 * Time: 16:36
 */

namespace app\admin\controller;

use \app\admin\model\Admin;
use app\admin\model\ActionLog;
use app\admin\validate\AdminValidate;
use \app\common\controller\Common;
use think\Exception;
use think\Session;

class User extends Common
{
    public function lists()
    {
        $this->assign('users',Admin::getLists(array('id'=>['not in',1])));
        return $this->fetch();
    }

    public function add()
    {
        if ($this->request->isPost()) {
            try {
                $param = $this->request->param();
                $validate = new AdminValidate();
                if (!$validate->scene('add')->check($param)) throw new Exception($validate->getError());
                $param['password'] = Admin::encryption($param['password']);
                if (!model('admin')->save($param)) throw new Exception('Server Error');
            } catch (Exception $exception) {
                return json(array('code'=>0,'msg'=>$exception->getMessage()));
            }
            return json(array('code'=>1,'msg'=>'创建成功'));
        }
        return $this->fetch();
    }

    public function index()
    {
        if ($this->request->isPost()) {
            try{
                $param = $this->request->param();
                if (empty($param['password'])) {
                    unset($param['password']);
                } else {
                    $param['password'] = md5($param['password']);
                }
                $validate = new AdminValidate();
                if ($validate->scene('edit')->check($param) === false) throw new Exception($validate->getError());
                if (!model('admin')->save($param,['id'=>$this->uid])) throw new Exception('Server Error');
            }catch (Exception $e) {
                return json(array('code'=>0,'msg'=>$e->getMessage()));
            }
            return json(array('code'=>1,'msg'=>'修改成功'));
        }
        # 获取用户操作记录
        $this->assign('data',ActionLog::getUserLog(Session::get('uid')));
        return $this->fetch();
    }

    public function logout()
    {
        Session::set('uid',null);
        Session::set('username',null);
        $this->redirect(url('admin/login/login'));
    }
}
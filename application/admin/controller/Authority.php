<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/11
 * Time: 14:52
 */

namespace app\admin\controller;

use app\admin\model\Auth;
use app\admin\validate\AuthRoleValidate;
use \app\common\controller\Common;
use think\Exception;
use think\Validate;

class Authority extends Common
{
    public function role()
    {
        $auth = new Auth();
        $this->assign('roles',$auth->getRoleList());
        return $this->fetch();
    }

    public function role_add()
    {
        if ($this->request->isPost()) {
            try {
                $param = $this->request->param();
                $validate = new AuthRoleValidate();
                if ($validate->check($param) === false) throw new Exception($validate->getError());
                $auth = new Auth();
                if (!$auth->createRole($param['name'],$param['remark'])) throw new Exception('Server Error');
            } catch ( Exception $exception) {
                return json(array('code'=>0,'msg'=>$exception->getMessage()));
            }
            return json(array('code'=>1,'msg'=>'创建成功'));
        }
        return $this->fetch('add');
    }

    public function rule_setting()
    {
        $id   = $this->request->param('id');
        $auth = new Auth();
        $LResult = $auth->RoleGetRule($id);
        if ($this->request->isPost()) {
            try {
                $param = $this->request->param();
                $rules = [
                    'id' => 'require'
                ];
                $validate = new Validate($rules);
                if (!$validate->check($param)) throw new Exception($validate->getError());
                if ($LResult) {
                    $auth->deleteRuleOnRole($id);
                }
                if (!$auth->createRuleOnRole($param)) throw new Exception('Server Error');
            } catch (Exception $exception) {
                return json(array('code'=>0,'msg'=>$exception->getMessage()));
            }
            return json(array('code'=>1,'msg'=>'权限设置成功'));
        }
        $result = is_null($LResult)?array():unserialize($LResult->child);
        $this->assign('id',$id);
        $this->assign('rules',$auth->getRuleList());
        $this->assign('result',$result);
        return $this->fetch();
    }

    public function role_setting()
    {
        $id   = $this->request->param('id');
        $auth = new Auth();
        $userRole = $auth->roleGetUser($id);
        if ($this->request->isPost()) {
            try {
                $param = $this->request->param();
                if ($userRole) {
                    $auth->deleteUserOnRole($id);
                }
                if (!$auth->createRoleOnUser($param)) throw new Exception($auth->getError());
            } catch (Exception $exception) {
                return json(array('code'=>0,'msg'=>$exception->getMessage()));
            }
            return json(array('code'=>1,'msg'=>'权限设置成功'));
        }
        $result = is_null($userRole)?array():$userRole;
        $this->assign('id',$id);
        $this->assign('result',$result);
        $this->assign('roles',$auth->getRoleList());
        return $this->fetch();
    }

    public function role_edit()
    {
        if ($this->request->isPost()) {
            try {
                $param = $this->request->param();
                $validate = new AuthRoleValidate();
                if ($validate->check($param) === false) throw new Exception($validate->getError());
                $auth = new Auth();
                if (!$auth->updateRole($param['id'],$param['name'],$param['remark'])) throw new Exception('Server Error');
            } catch (Exception $exception) {
                return json(array('code'=>0,'msg'=>$exception->getMessage()));
            }
            return json(array('code'=>1,'msg'=>'修改成功'));
        }
        $id   = $this->request->param('id');
        $auth = new Auth();
        $this->assign('role',$auth->getRole($id));
        return $this->fetch();
    }

    public function delete_role()
    {
        if ($this->request->isAjax()) {
            try{
                $id = $this->request->param('id');
                if (is_null($id)) throw new Exception('参数错误');
                $auth = new Auth();
                if (!$auth->deleteRole($id)) throw new Exception('Server Error');
            }catch (Exception $exception) {
                return json(array('code'=>0,'msg'=>$exception->getMessage()));
            }
            return json(array('code'=>1,'msg'=>'删除成功'));
        } else {
            return json(array('code'=>0,'msg'=>'请求方式错误'));
        }
    }
}
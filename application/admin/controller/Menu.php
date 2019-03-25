<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/27
 * Time: 17:43
 */

namespace app\admin\controller;


use app\admin\model\Auth;
use app\admin\model\Menus;
use app\admin\validate\MenusValidate;
use app\common\controller\Common;
use think\Db;
use think\Exception;

class Menu extends Common
{
    public function index()
    {
        $this->assign('menu',Menus::getMenus());
        return $this->fetch();
    }

    public function add()
    {
        $this->assign('menu',Menus::getMenus());
        return $this->fetch();
    }

    public function update()
    {
        if ($this->request->isPost()) {
            try{
                $param = $this->request->param();
                $validate = new MenusValidate();
                if ($validate->scene('edit')->check($param) === false) {
                    throw new Exception($validate->getError());
                }
                $param = transition($param);
                Db::startTrans();
                if ($param['auth_menu'] and $param['module'] and $param['controller'] and $param['method']) {
                    $path   = $param['module'].'/'.$param['controller'].'/'.$param['method'];
                    $result = Menus::getRuleParam($param['id'],'rule_param')->rule_param;
                    $auth = new Auth();
                    if ($result) {
                        $auth->updateRule($result,$path,$param['name']);
                        $param['rule_param'] = $result;
                    } else {
                        $param['rule_param'] = $auth->createRule($path,$param['name']);
                    }
                }
                if (!model('menus')->save($param,['id'=>$param['id']])) throw new Exception('Server Error');
                Db::commit();
            }catch (Exception $e) {
                Db::rollback();
                return json(array('code'=>0,'msg'=>$e->getMessage()));
            }
            return json(array('code'=>1,'msg'=>'修改成功'));
        }
        $id = $this->request->param('id');
        $at_menu = model('menus')->where('id',$id)->find();
        $this->assign('result',$at_menu);
        $this->assign('menu',Menus::getMenus());
        return $this->fetch('edit');
    }

    public function create()
    {
        if ($this->request->isAjax()) {
            try{
                $param = $this->request->post();
                $validate = new MenusValidate();
                if ($validate->scene('add')->check($param) === false) {
                    throw new Exception($validate->getError());
                }
                $param = transition($param);
                Db::startTrans();
                if ($param['auth_menu'] and $param['module'] and $param['controller'] and $param['method']) {
                    $path = $param['module'].'/'.$param['controller'].'/'.$param['method'];
                    $auth = new Auth();
                    $param['rule_param'] = $auth->createRule($path,$param['name']);
                }
                if (!model('menus')->insert($param)) throw new Exception('Server Error');
                Db::commit();
            }catch (Exception $e) {
                Db::rollback();
                return json(array('code'=>0,'msg'=>$e->getMessage()));
            }
            return json(array('code'=>1,'msg'=>'添加成功'));
        } else {
            return json(array('code'=>0,'msg'=>'请求方式错误'));
        }
    }

    public function delete()
    {
        if ($this->request->isAjax()) {
           try{
               $id = $this->request->param('id');
               if (is_null($id)) throw new Exception('参数错误');
               Db::startTrans();
               $model= model('menus');
               $node = $model->where('id',$id)->find();
               $node_parent = $model->where('parent_id',$id)->count();
               if (is_null($node) || $node_parent) throw new Exception('当前菜单存在子节点不能删除');
               $result = Menus::getRuleParam($id,'rule_param')->rule_param;
               if ($result) {
                    $auth = new Auth();
                    $auth->deleteRule($result);
               }
               if (!$model->where('id',$id)->delete()) throw new Exception('Server Error');
               Db::commit();
           }catch (Exception $exception) {
               Db::rollback();
               return json(array('code'=>0,'msg'=>$exception->getMessage()));
           }
            return json(array('code'=>1,'msg'=>'删除成功'));
        } else {
            return json(array('code'=>0,'msg'=>'请求方式错误'));
        }
    }

    public function icon()
    {
        return $this->fetch();
    }
}
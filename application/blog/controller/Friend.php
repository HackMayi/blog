<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/3
 * Time: 20:59
 */

namespace app\blog\controller;


use app\blog\model\BlogFriend;
use app\blog\validate\BlogFriendValidate;
use app\common\controller\Common;
use think\Exception;

class Friend extends Common
{
    public function index()
    {
        $this->assign('menu',BlogFriend::getLists());
        return $this->fetch();
    }

    public function add()
    {
        return $this->fetch();
    }

    public function create()
    {
        if ($this->request->isAjax()) {
            try{
                $param = $this->request->post();
                $validate = new BlogFriendValidate();
                if ($validate->check($param) === false) {
                    throw new Exception($validate->getError());
                }
                if (!model('blog_friend')->save($param)) throw new Exception('Server Error');
            }catch (Exception $e) {
                return json(array('code'=>0,'msg'=>$e->getMessage()));
            }
            return json(array('code'=>1,'msg'=>'添加成功'));
        } else {
            return json(array('code'=>0,'msg'=>'请求方式错误'));
        }
    }

    public function update()
    {
        if ($this->request->isPost()) {
            try{
                $param = $this->request->param();
                $validate = new BlogFriendValidate();
                if ($validate->check($param) === false) {
                    throw new Exception($validate->getError());
                }
                if (!model('blog_friend')->save($param,['id'=>$param['id']])) throw new Exception('Server Error');
            }catch (Exception $e) {
                return json(array('code'=>0,'msg'=>$e->getMessage()));
            }
            return json(array('code'=>1,'msg'=>'修改成功'));
        }
        $id = $this->request->param('id');
        $at_menu = model('blog_friend')->where('id',$id)->find();
        $this->assign('result',$at_menu);
        return $this->fetch('edit');
    }

    public function delete()
    {
        if ($this->request->isAjax()) {
            try{
                $id    = $this->request->param('id');
                if (is_null($id)) throw new Exception('参数错误');
                if (!model('blog_friend')->where('id',$id)->delete()) throw new Exception('Server Error');
            }catch (Exception $exception) {
                return json(array('code'=>0,'msg'=>$exception->getMessage()));
            }
            return json(array('code'=>1,'msg'=>'删除成功'));
        } else {
            return json(array('code'=>0,'msg'=>'请求方式错误'));
        }
    }
}
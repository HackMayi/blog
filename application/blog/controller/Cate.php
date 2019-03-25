<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/28
 * Time: 22:30
 */

namespace app\blog\controller;


use app\blog\model\BlogCate;
use app\blog\validate\BlogCateValidate;
use app\common\controller\Common;
use think\Exception;

class Cate extends Common
{
    public function index()
    {
        $this->assign('menu',BlogCate::getCateA());
        return $this->fetch();
    }

    public function add()
    {
        $this->assign('menu',BlogCate::getCateA());
        return $this->fetch();
    }

    public function create()
    {
        if ($this->request->isAjax()) {
            try{
                $param = $this->request->post();
                $validate = new BlogCateValidate();
                if ($validate->scene('add')->check($param) === false) {
                    throw new Exception($validate->getError());
                }
                if (!model('blog_cate')->save($param)) throw new Exception('Server Error');
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
                $validate = new BlogCateValidate();
                if ($validate->scene('add')->check($param) === false) {
                    throw new Exception($validate->getError());
                }
                if (!model('blog_cate')->save($param,['id'=>$param['id']])) throw new Exception('Server Error');
            }catch (Exception $e) {
                return json(array('code'=>0,'msg'=>$e->getMessage()));
            }
            return json(array('code'=>1,'msg'=>'修改成功'));
        }
        $id = $this->request->param('id');
        $at_menu = model('blog_cate')->where('id',$id)->find();
        $this->assign('result',$at_menu);
        $this->assign('menu',BlogCate::getCateA());
        return $this->fetch('edit');
    }

    public function delete()
    {
        if ($this->request->isAjax()) {
            try{
                $id    = $this->request->param('id');
                if (is_null($id)) throw new Exception('参数错误');
                $count = BlogCate::getCateArticleCount($id);
                if ($count > 0) throw new Exception('当前分类下存在文章内容不能删除');
                if (!model('blog_cate')->where('id',$id)->delete()) throw new Exception('Server Error');
            }catch (Exception $exception) {
                return json(array('code'=>0,'msg'=>$exception->getMessage()));
            }
            return json(array('code'=>1,'msg'=>'删除成功'));
        } else {
            return json(array('code'=>0,'msg'=>'请求方式错误'));
        }
    }
}

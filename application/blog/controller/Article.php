<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/1
 * Time: 12:56
 */

namespace app\blog\controller;


use app\blog\model\BlogArticle;
use app\blog\model\BlogCate;
use app\blog\validate\BlogArticleValidate;
use app\common\controller\Common;
use think\Exception;

class Article extends Common
{
    public function index()
    {
        $model = new BlogArticle();
        $result = $model->getList();
        $this->assign('menu',$result);
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
                $validate = new BlogArticleValidate();
                if ($validate->scene('add')->check($param) === false) {
                    throw new Exception($validate->getError());
                }
                if (isset($param['file'])) unset($param['file']);
                if (!model('blog_article')->save($param)) throw new Exception('Server Error');
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
                $validate = new BlogArticleValidate();
                if ($validate->scene('add')->check($param) === false) {
                    throw new Exception($validate->getError());
                }
                if (isset($param['file'])) unset($param['file']);
                $param['update_at'] = time();
                if (!model('blog_article')->save($param,['id'=>$param['id']])) throw new Exception('Server Error');
            }catch (Exception $e) {
                return json(array('code'=>0,'msg'=>$e->getMessage()));
            }
            return json(array('code'=>1,'msg'=>'修改成功'));
        }
        $id = $this->request->param('id');
        $at_menu = model('blog_article')->where('id',$id)->find();
        $this->assign('result',$at_menu);
        $this->assign('menu',BlogCate::getCateA());
        return $this->fetch('edit');
    }

    public function delete()
    {
        $model = new BlogArticle();
        return $this->remove($model->getTable());
    }
}
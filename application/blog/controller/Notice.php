<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/8
 * Time: 17:59
 */

namespace app\blog\controller;


use app\blog\model\BlogNotice;
use app\common\controller\Common;
use think\image\Exception;
use think\Validate;

class Notice extends Common
{
    public function index()
    {
        $this->assign('notices',BlogNotice::getList());
        return $this->fetch();
    }

    public function add()
    {
        if ($this->request->isPost())
        {
            $param = $this->request->param();
            unset($param['file']);
            if ($this->check($param) === false) {
                return json(array('code'=>0,'msg'=>'数据验证失败'));
            }
            if (model('blog_notice')->save($param)) {
                return json(array('code'=>1,'msg'=>'发布成功'));
            } else {
                return json(array('code'=>0,'msg'=>'发布失败'));
            }
        }
        return $this->fetch();
    }

    public function update()
    {
        if ($this->request->isPost())
        {
            $param = $this->request->param();
            unset($param['file']);
            if ($this->check($param) === false) {
                return json(array('code'=>0,'msg'=>'数据验证失败'));
            }
            if (model('blog_notice')->save($param,array('id'=>$param['id']))) {
                return json(array('code'=>1,'msg'=>'修改成功'));
            } else {
                return json(array('code'=>0,'msg'=>'修改失败'));
            }
        }
        $id = $this->request->param('id');
        $result = BlogNotice::get($id);
        $this->assign('result',$result);
        return $this->fetch();
    }

    public function delete()
    {
        if ($this->request->isAjax()) {
            try{
                $id    = $this->request->param('id');
                if (is_null($id)) throw new Exception('参数错误');
                if (!model('blog_notice')->where('id',$id)->delete()) throw new Exception('Server Error');
            }catch (Exception $exception) {
                return json(array('code'=>0,'msg'=>$exception->getMessage()));
            }
            return json(array('code'=>1,'msg'=>'删除成功'));
        } else {
            return json(array('code'=>0,'msg'=>'请求方式错误'));
        }
    }

    protected function check($param)
    {
        $rules = [
            'content' => 'require'
        ];
        $validate = new Validate($rules);
        if ($validate->check($param)) {
            return true;
        } else {
            return false;
        }
    }
}
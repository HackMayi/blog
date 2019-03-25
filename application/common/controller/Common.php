<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/26
 * Time: 19:44
 */
namespace app\common\controller;

use app\admin\model\Menus;
use think\Controller;
use think\Exception;
use think\Session;

class Common extends Controller
{
    protected $uid;

    public function _initialize()
    {
        # 检查登录状态
        if(!Session::has('username') || !Session::has('uid')) {
            $this->redirect('admin/login/login');
        }
        $this->uid = Session::get('uid');
    }

    public function upload($fileName = 'uploads')
    {
        $path = '';
        $path_url = '';
        try{
            $file = request()->file('file');
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . $fileName);
                if($info){
                    $path = 'http://'. $_SERVER['SERVER_NAME'] .'\\'. $fileName .'\\'. $info->getSaveName();
                    $path_url = '\\'.$fileName .'\\'. $info->getSaveName();
                }else{
                    throw new Exception($file->getError());
                }
            }
        }catch (Exception $e) {
            return json(array('code'=>0,'msg'=>$e->getMessage()));
        }
        return json(array('code'=>1,'msg'=>'上传成功','data'=>array('path'=>$path,'path_url'=>$path_url)));
    }

    /**
     * 通用删除
     * @param $ids
     * @param $table
     * @return \think\response\Json
     */
    protected function remove($table)
    {
        try{
            $ids = $this->request->param('id/a');
            if (!empty($ids) and !empty($table)) {
                $object = db($table);
                $ob_key = $object->getPk();
                $where[$ob_key] = ['in',$ids];
                $result = $object->where($where)->delete();
                if (!$result)
                    throw new Exception('Server Error');
            } else {
                throw new Exception('缺少参数');
            }
        }catch (Exception $exception) {
            return json(array('code'=>0,'msg'=>$exception->getMessage()));
        }
        return json(array('code'=>1,'msg'=>'删除成功'));
    }

    /**
     * 通用修改状态
     * @param $table
     * @param $field
     * @param $value
     * @return \think\response\Json
     */
    public function changeStatus($table, $field, $value)
    {
        try{
            $ids = $this->request->param('id/a');
            if (!empty($ids) and !empty($table)) {
                $object = db($table);
                $ob_key = $object->getPk();
                $where[$ob_key] = ['in',$ids];
                $result = $object->where($where)->setField($field,$value);
                if (!$result)
                    throw new Exception('没有需要操作的数据');
            } else {
                throw new Exception('缺少参数');
            }
        }catch (Exception $exception) {
            return json(array('code'=>0,'msg'=>$exception->getMessage()));
        }
        return json(array('code'=>1,'msg'=>'修改成功'));
    }
}
<?php
namespace app\admin\controller;

use app\admin\model\Menus;
use app\blog\model\BlogArticle;
use app\common\controller\Common;
use think\Loader;

class Index extends Common
{
    public function index()
    {
        $menus   = Menus::getMenus(array('status'=>1));
        $result  = $this->menuLists($menus);
        Loader::import('statistics.StatPv',EXTEND_PATH);
        $model   = new \StatPv();
        $arr     = $model->getData();
        $arr['article_count'] = BlogArticle::getCount();
        $this->assign('arr',$arr);
        $this->assign('lists',$result);
        return $this->fetch();
    }

    public function menuLists($menus = array(),$pId = 0)
    {
        $tree = array();
        foreach($menus as $k => $v)
        {
            if (empty($v['module'])) {
                $v['url'] = 'JavaScript:;';
            } else {
                $v['url'] = '/'.$v['module'].'/'.$v['controller'].'/'.$v['method'];
            }
            if($v['parent_id'] == $pId)
            {
                $v['node'] = $this->menuLists($menus, $v['id']);
                $tree[] = $v;
            }
        }
        return $tree;
    }
}

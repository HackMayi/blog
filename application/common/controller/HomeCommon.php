<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/5
 * Time: 14:08
 */

namespace app\common\controller;


use app\blog\model\BlogCate;
use app\home\model\BlogFriend;
use think\Controller;

class HomeCommon extends Controller
{
    public function _initialize()
    {
        #获取分类
        $menu = BlogCate::getCateA();

        $article_read_sum = [];
        foreach ($menu as $item) {
            $item['sum'] = BlogCate::getCateArticleReadSum($item->id);
            $article_read_sum[] = $item;
        }
        #对分类进行阅读量排序
        $sort = function ($arr) use (&$sort) {
            $len = count($arr);
            if ($len <= 1) {
                return $arr;
            }
            $initialize = $arr[0];
            $left_array = array();
            $right_array = array();
            for ($i = 1; $i < $len;++$i) {
               if ($initialize['sum'] < $arr[$i]['sum']) {
                   $left_array[] = $arr[$i];
               } else {
                   $right_array[] = $arr[$i];
               }
            }
            $left_array = $sort($left_array);
            $right_array = $sort($right_array);
            return array_merge($left_array,array($initialize),$right_array);
        };

        #阅读排行
        $this->assign('menu',$sort($article_read_sum));
        $this->assign('links',BlogFriend::getList());
    }

    /**
     * 默认跳转地址
     * @param string $url
     */
    public function jump_url($url = 'home/blog/index')
    {
        $this->redirect(url($url));
    }

    protected static function getEndTime()
    {
        return mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
    }
}
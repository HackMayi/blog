<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/5
 * Time: 14:56
 */
namespace app\home\model;

use app\admin\model\Menus;
use think\Model;

class BlogCate extends Model
{
    public static function getCateA()
    {
        $cateA = model('blog_cate')->select();
        return Menus::disposeData($cateA);
    }

    public static function getCateArticle($id,$sum = 10)
    {
        $result = self::alias('a')
                        ->join('blog_article b','a.id = b.cate_id','left')
                        ->field('a.cate_name,b.*')
                        ->where(array('b.cate_id' => $id))
                        ->paginate($sum);
        return array('list'=>BlogArticle::getCommentCount($result),'page'=>$result->render());
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/28
 * Time: 23:00
 */

namespace app\blog\model;


use app\admin\model\Menus;
use think\Model;

class BlogCate extends Model
{
    protected $createTime = 'create_at';
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    public static function getCateA()
    {
        $cateA = model('blog_cate')->select();
        return Menus::disposeData($cateA);
    }

    public static function getCateArticleCount($id)
    {
        return self::alias('a')
                     ->join('blog_article b','a.id = b.cate_id','left')
                     ->where(array('a.id' => $id))
                     ->count();
    }

    public static function getCateArticleReadSum($id)
    {
        return self::alias('a')
                     ->join('blog_article b','a.id = b.cate_id','left')
                     ->where(array('a.id' => $id))
                     ->sum('b.read_number');
    }
}
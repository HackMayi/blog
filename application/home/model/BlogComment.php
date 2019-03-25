<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/5
 * Time: 20:47
 */

namespace app\home\model;


use think\Model;

class BlogComment extends Model
{
    protected $createTime = 'create_at';
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    public static function getComment($where = array(),$sum = 10)
    {
        $comments = self::where($where)->order('create_at','desc')->paginate($sum);
        return array('list'=>$comments,'page'=>$comments->render());
    }

    public static function getArticleComment($article_id)
    {
        return self::where(array('article_id' => $article_id))->cache(true)->count();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/1
 * Time: 19:06
 */

namespace app\blog\model;


use think\Model;

class BlogArticle extends Model
{
    protected $createTime = 'create_at';
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    public function getList()
    {
        $result = $this->alias('a')
                       ->join('blog_cate b','a.cate_id = b.id','left')
                       ->field('a.*,b.cate_name')
                       ->order('create_at','desc')
                       ->paginate(10);
        return array('list'=>$result,'page'=>$result->render());
    }

    public static function getCount()
    {
        return self::count();
    }
}
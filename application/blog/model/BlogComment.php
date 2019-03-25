<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/16
 * Time: 19:30
 */

namespace app\blog\model;


use think\Model;

class BlogComment extends Model
{
    public function getLast($where = array(), $sum = 10)
    {
        $result = $this->alias('a')
                       ->join('blog_article b','a.article_id = b.id','left')
                       ->field('a.*,b.title')
                       ->where($where)
                       ->paginate($sum);
        return array('list' => $result, 'page' => $result->render());
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/5
 * Time: 15:34
 */

namespace app\home\model;


use think\Model;

class BlogArticle extends Model
{
    public static function getLists($where = array(),$orderField = 'a.create_at',$order = 'desc',$sum = 10)
    {
        $result = self::alias('a')
                        ->join('blog_cate b','a.cate_id = b.id','left')
                        ->field('a.id,a.title,a.intro,a.cover,a.read_number,a.create_at,a.path,b.cate_name,b.id as cate_id')
                        ->where($where)
                        ->order($orderField,$order)
                        ->paginate($sum);

        return array('list'=>self::getCommentCount($result),'page'=>$result->render());
    }

    public static function searchArticle($keywords,$sum = 10)
    {
        $result = self::alias('a')
                        ->join('blog_cate b','a.cate_id = b.id','left')
                        ->field('a.*,b.cate_name,b.id as cate_id')
                        ->where('a.title|a.content','like','%'.$keywords.'%')
                        ->order('create_at','desc')
                        ->paginate($sum);
        return array('list'=>self::getCommentCount($result),'page'=>$result->render());
    }

    public static function getArticle($id,$field='a.*,b.cate_name,b.id as cate_id')
    {
        if ($id) {
            $article = self::alias('a')
                ->join('blog_cate b','a.cate_id = b.id','left')
                ->field($field)
                ->where(array('a.id'=>$id))
                ->find();
            return $article;
        } else {
            return array();
        }
    }

    public static function getUpAndDownArticle($id)
    {
        $column = self::column('id');
        $site   = array_search($id,$column);
        $result['last'] = ($site-1)<=0 ? 0 : $column[$site-1];
        $result['next'] = ($site+1) >= (count($column)) ? 0 : $column[$site+1];
        return $result;
    }

    /**
     * 增加新闻阅读量
     * @param $id
     * @param string $field
     * @return int|true
     * @throws \think\Exception
     */
    public static function addReadNumber($id,$field = 'read_number')
    {
        return self::where(array('id'=>$id))->setInc($field);
    }

    /**
     * 获取文章评论总数
     * @param $params
     * @param array $result
     * @return array
     */
    public static function getCommentCount($params, $result = array())
    {
        $data = function ($param) use (&$result) {
            foreach ($param as $value) {
                $value['comment_count'] = BlogComment::getArticleComment($value['id']);
                $result[] = $value;
            }
            return $result;
        };
        return $data($params);
    }
}
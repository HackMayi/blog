<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/5
 * Time: 14:07
 */
namespace app\home\controller;

use app\common\controller\HomeCommon;
use app\home\model\BlogArticle;
use app\home\model\BlogCate;
use app\home\model\BlogComment;
use app\home\model\BlogFriend;
use app\home\model\BlogNotice;
use think\Cache;
use think\Exception;
use think\Validate;

class Blog extends HomeCommon
{
    public $cache_name = 'blog_read_';

    public function index()
    {
        $keywords = $this->request->param('keywords','');
        if ($keywords) {
            $this->assign('articles',BlogArticle::searchArticle($keywords));
        } else {
            $this->assign('articles',BlogArticle::getLists(array('a.status'=>1)));
        }
        $this->assign('ranking',BlogArticle::getLists(array('a.status'=>1),'a.read_number'));
        return $this->fetch();
    }

    public function notice()
    {
        $this->assign('notices',BlogNotice::getList());
        return $this->fetch();
    }

    public function about()
    {
        return $this->fetch();
    }

    public function search()
    {
        $search = $this->request->param('search','');
        if (empty($search)) {
            $result = array();
        } else {
            $result = BlogArticle::searchArticle($search);
        }
        $this->assign('result',$result);
        return $this->fetch();
    }

    public function cate()
    {
        $cate_id = $this->request->param('cate_id');
        if (is_null($cate_id)) $this->jump_url();
        $article = BlogCate::getCateArticle($cate_id);
        $this->assign('ranking',BlogArticle::getLists(array('a.status'=>1)));
        $this->assign('articles',$article);
        return $this->fetch();
    }

    public function trends()
    {
        return $this->fetch();
    }

    public function links()
    {
        $this->assign('links',BlogFriend::getList());
        return $this->fetch();
    }

    public function archives()
    {
        return $this->fetch();
    }

    public function message()
    {
        $this->assign('result',BlogComment::getComment(array('article_id'=>0,'status'=>1)));
        return $this->fetch();
    }

    public function addComment()
    {
        try {
            $param = $this->request->param();
            if ($param['type'] == 'message') {
                $rule = [
                    'content' => 'require',
                ];
            } else {
                $rule = [
                    'content' => 'require',
                    'article_id' => 'require',
                ];
            }
            $validate = new Validate($rule);
            if (!$validate->check($param['data'])) throw new Exception($validate->getError());
            $param['data']['content'] = htmlspecialchars($param['data']['content']);
            if (!model('blog_comment')->save($param['data'])) throw new Exception('评论失败,请联系管理员');
        } catch (Exception $exception) {
            return json(array('code'=>0,'msg'=>$exception->getMessage()));
        }
        return json(array('code'=>1,'msg'=>'提交成功,审核后即可显示'));
    }

    public function detail()
    {
        $aid = $this->request->param('id');
        if ($this->articleRead($aid)) {
            BlogArticle::addReadNumber($aid);
        }
        if (is_null($aid)) $this->jump_url();
        $article     = BlogArticle::getArticle($aid);
        $upAndDown   = BlogArticle::getUpAndDownArticle($aid);
        $lastArticle = BlogArticle::getArticle($upAndDown['last']);
        $nextArticle = BlogArticle::getArticle($upAndDown['next']);
        $this->assign('lastArticle',$lastArticle);
        $this->assign('nextArticle',$nextArticle);
        $this->assign('article',$article);
        $this->assign('result',BlogComment::getComment(array('article_id'=>$aid,'status'=>1)));
        $this->assign('ranking',BlogArticle::getLists(array('a.status'=>1)));
        return $this->fetch();
    }

    /**
     * 阅读量/IP每天只统计一次
     * @param $id
     * @return bool
     */
    protected function articleRead($id)
    {
        $ip      = $this->request->ip();
        $name    = $this->cache_name.$id.'_'.$ip;
        $result  = Cache::get($name);
        if (!$result) {
            $endTime = self::getEndTime();
            $time    = $endTime - time();
            Cache::set($name,time(),$time);
            return true;
        } else {
            return false;
        }
    }

}
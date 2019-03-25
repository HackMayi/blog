<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/18
 * Time: 16:25
 */

namespace app\command;


use app\blog\model\BlogArticle;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Log;

class PushBaiDu extends Command
{
    protected $api = 'http://data.zz.baidu.com/urls?site=www.pcdhw.cn&token=RUnw03ufYbZqWc5j';
    protected $host = 'http://www.pcdhw.cn/';
    protected $timeOut = 60;

    protected function configure()
    {
        $this->setName('PushBaiDu')->setDescription('推送百度文章');
    }

    protected function execute(Input $input, Output $output)
    {
        $articles = BlogArticle::all(function ($query) {
            $query->where('status', 1)->field('id')->order('id', 'desc');
        });
        $url = array();
        if (!empty($articles)) {
            foreach ($articles as $article) {
                $url[] = $this->host.'home/blog/detail/id/'.$article->id.'.html';
            }
        }
        $result = json_decode($this->http_post($url));
        if (isset($result->error)) {
            Log::record($result->message);
        }
        $output->writeln('推送成功,剩余'.$result->remain.'次');
    }

    protected function http_post($params)
    {
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $this->api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $params),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        return curl_exec($ch);
    }
}
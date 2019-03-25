<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/25
 * Time: 11:22
 */

namespace app\command;


use app\common\model\BlogCounterLog;
use think\console\Command;
use think\console\Input;
use think\console\Output;

class Counter extends Command
{
    protected function configure()
    {
        $this->setName('Counter')->setDescription('每日访问量统计');
    }

    protected function execute(Input $input, Output $output)
    {
        $result = file_get_contents('./public/start.txt');
        $result = unserialize($result);
        $time   = date('Y-m-d');
        $day    = BlogCounterLog::getTime(array('date_time' => $time));
        if (is_null($day)) {
            BlogCounterLog::create([
                'date_time' => $time
                ,'today'    => $result[date('Ymd')]
            ]);
        } else {
            $output->write('今日统计已创建');exit();
        }
        $output->write('入库成功');
    }
}
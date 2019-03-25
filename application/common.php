<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function transition($params = array())
{
    $result = array();
    foreach ($params as $key =>$param)
    {
        if ($key == 'module' || $key == 'controller' || $key == 'method') {
            $param = strtolower($param);
        }
        $result[$key] = $param;
    }
    return $result;
}
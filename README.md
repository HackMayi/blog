ThinkPhp5.0 + X-admin 前端模板,博客使用黑色主题模板
===============

[![Total Downloads](https://poser.pugx.org/topthink/think/downloads)](https://packagist.org/packages/topthink/think)
[![Latest Stable Version](https://poser.pugx.org/topthink/think/v/stable)](https://packagist.org/packages/topthink/think)
[![Latest Unstable Version](https://poser.pugx.org/topthink/think/v/unstable)](https://packagist.org/packages/topthink/think)
[![License](https://poser.pugx.org/topthink/think/license)](https://packagist.org/packages/topthink/think)

示例图片

后台:
![Image text](https://raw.githubusercontent.com/HackMayi/blog/master/images/Snipaste_2019-03-25_20-31-08.png)

前台:
![Image text](https://raw.githubusercontent.com/HackMayi/blog/master/images/Snipaste_2019-03-25_20-31-29.png)
![Image text](https://raw.githubusercontent.com/HackMayi/blog/master/images/Snipaste_2019-03-25_20-31-41.png)
![Image text](https://raw.githubusercontent.com/HackMayi/blog/master/images/Snipaste_2019-03-25_20-31-54.png)
1,安装

 + 1,克隆代码
        
        git clone https://github.com/HackMayi/blog.git

 + 2,安装
 
        composer install


2,数据库使用thinkPHP migrate创建

 
 + 1,修改database数据库配置创建数据库
 
        // 服务器地址
        'hostname'        => '127.0.0.1',
        // 数据库名
        'database'        => '',
        // 用户名
        'username'        => '',
        // 密码
        'password'        => '',
        
 + 2,创建数据表
 +  php think migrate
        
        默认登录密码:
        admin  123456
 + 3,后台地址
        
        xxx.com/admin/index/index 
 + 4,配置网站信息
 
 

> ThinkPHP5的运行环境要求PHP5.4以上。

详细开发文档参考 [ThinkPHP5完全开发手册](http://www.kancloud.cn/manual/thinkphp5)

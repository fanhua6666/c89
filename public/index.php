<?php
//初始化项目composer：   在里面输入composer init
//这是框架单一入口的文件
//然后加载类库需要满足两个条件：1.include 2.use导入命名空间
//生成vendor目录之后然后执行命令：composer dump

//加载vendor/autoload.php
require "../vendor/autoload.php";
//在composer.json配置文件中加入autoload.php
//然后在项目的根目录下执行：composer dump
//调用启动类中run方法
\houdunwang\core\Boot::run();

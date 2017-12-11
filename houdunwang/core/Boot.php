<?php
//设置命名空间2.因为路劲需要是一致的
namespace houdunwang\core;

use app\home\controller\Index;

/**
 * 启动类
 */
//创建一个类，实现要传入的数据
class Boot
{
    //创建一个静态方法，因为需要调用静态方法来实现组合路劲
    public static function run()
    {
        //错误处理
//        self::handler();
        //输出一个run在页面如果正常输出的话证明程序运行到了这里
//        echo 'run';
        //加载完函数库之后然后执行初始化
        self::init();
        //执行应用
        self::appRun();
    }

    //错误异常处理
//    public static function handler()
//    {
//        $whoops = new \Whoops\Run;
//        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
//        $whoops->register();
//    }

    public static function appRun()
    {
        //if判断，因为需要判断$_GET是否有传过来参数
        if (isset($_GET['s'])) {//地址栏有s参数
            //测试地址：?s=home/article/index:模块/控制器/方法
            $s = $_GET['s'];
            //p($_GET['s']);die;
            //将$s转为数组
            //把参数设置为数组，因为需要获得路劲
            $info = explode('/', $s);
            //p($info);die;
            //模块
            //创建一个变量，因为需要获得到数组中的第一个参数
            $m = $info[0];
            //控制器类,首字母大写，因为他是类名字
            $c = ucfirst($info[1]);
            //方法
            $a = $info[2];
        } else {
            //地址栏没有参数，需要给默认值
            //不存在参数的时候给默认值
            //模块
            //创建变量，因为需要把默认参数设置为home
            $m = 'home';
            //控制器类
            //创建变量，因为默认的参数需要设置为entry
            $c = 'Index';
            //方法
            //创建变量，因为默认的参数需要设置为index
            $a = 'index';
        }
        //定义常量,为了在后面是使用的时候比较方便，以为define定义的常量可以不受命名空间限制
        //定义三个常量，因为view里面的类组合模板路劲的
        //创建常量并赋值，因为需要组合路劲的时候调用
        define('MODULE', $m);
        //把$c赋值给常量，要在别的类里使用来组合路径所以要用来当作全局的变量使用
        define('CONTROLLER', $c);
        //把$a赋值给常量，要在别的类里使用来组合路径所以要用来当作全局的变量使用
        define('ACTION', $a);
        //完成组合路劲
        $controller = "\app\\{$m}\controller\\{$c}";
        echo call_user_func_array([new $controller, $a], []);
    }

    /**
     * 初始化框架
     */
    public static function init()
    {
        //声明头部
        //如果不加头部，浏览器输出会出现乱码
        header('Content-type:text/html;charset=utf8');
        //1.设置时区
        //2.不设置时区，使用时间的时候可能会出现时间不正确
        date_default_timezone_set('PRC');
        //3.开启session
        //如果已经有session_id()说明session开启过了
        //如果没有session_id，则再开启session
        //重复开启session，会导致报错
        //使用session必须开启，如果有session_id则不再重复开启session
        session_id() || session_start();
    }
}
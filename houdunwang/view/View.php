<?php
//设置命名空间
namespace houdunwang\view;
//创建一个类，因为需要调里面的函数
class View
{
    //创建方法2.因为需要调用类里面的方法
    public function __call($name, $arguments)
    {
        //p($name);die;//make
        //p($arguments);
        return self::runParse($name, $arguments);
    }
    //创建一个方法2.因为需要自动调用类里面的函数
    public static function __callStatic($name, $arguments)
    {
        //p($arguments);die;
        return self::runParse($name, $arguments);
    }

    public static function runParse($name, $arguments)
    {
//        p($arguments);
//        p($name);die;//make
        //(new Base)->$name($arguments);
        //返回调用方法2.因为需要组合路劲
        return call_user_func_array([new Base(), $name], $arguments);
    }

}
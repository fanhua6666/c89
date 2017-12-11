<?php
//设置命名空间，因为需要调用他
namespace app\home\controller;
//创建类，需要运行里面的数据
class Article{
    //创建方法因为需要调用页面的类
    public function index(){
        echo 'article';
    }

    public function add(){
        echo 'article add';
    }
}
<?php
//设置命名空间
namespace houdunwang\core;
/**
 * 公共父级类
 */
//创建一个类
class Controller{
    private $url;
    /**
     * 信息提示
     */
    public function message($msg){
        include './view/message.php';
    }
    /**
     * 跳转链接
     */
    public function setRedirect($url = ''){
        if($url){
            //说明指定了跳转地址
            $this->url = "location.href='$url'";
        }else{
            //说明没有给跳转地址，默认back
            $this->url  = "window.history.back()";
        }
        return $this;
    }
}
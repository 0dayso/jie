<?php
namespace Admin\Controller;

class Index{
    /**
    * 描述: 进入后判断管理员的是登录
    * @date: 2016年4月29日 下午4:49:05
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function Index(){
        if(empty($_SESSION['adminname'])){
            include ROOT.'Admin/View/login.html';
        }else{
            //进入主页
            include ROOT.'Admin/View/index.html';
        }
    }
    
    /**
    * 描述: 验证码操作
    * @date: 2016年4月29日 下午4:48:47
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function Code(){
        \Xin\Code::verifyImage();
    }
    
    /**
    * 描述: 登录操作
    * @date: 2016年4月29日 下午4:54:21
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function Login(){
        $flag = \Admin\Model\IndexHelp::Login();
        var_dump($_SESSION);
        //实现跳转
    }
}
?>
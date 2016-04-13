<?php
namespace Xin;

class Invoker{
    private $controllerArray;
    private $pathMessage;
    private $register;
    private $controller;
    private $action;
    
    function __construct(\Xin\Register $register){
        //获得配置文件
        $pathObj = new \Xin\Loadconfig(ROOT.'configs');
        $pathMessag = $pathObj->offsetGet('controller');
        $this->pathMessage = $pathMessag;
        //获得控制器合法名称
        $this->controllerArray = array_keys($pathMessag);
        //添加注册表
        $this->register = $register;
    }
    
    
    //判断请求的控制器和动作合法性
    function CheckController(){
        $controller = ucwords($this->register->GetValue('controller'));
        //控制器不在被允许的行列则设置默认的控制器(也可以跳转到错误页面)
        if(!in_array($controller, $this->controllerArray)){
            $this->register->SetValue('controller', 'Index');
            $controller = 'Index';
        }
        
        if(!in_array(ucwords($this->register->GetValue('action')), $this->pathMessage[$controller])){
            $this->register->SetValue('action', 'Index');
            $action = 'Index';
        }else{
            $action = ucwords($this->register->GetValue('action'));
        }
        echo $controller.'<br/>';
        echo $action;
        //创建控制器对象返回
        
    }
    
    //命令设置
    function SetCommand(AbstructCommand $command){
        
    }
    
    
    //通知命令执行
    
}

?>
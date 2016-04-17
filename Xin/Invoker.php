<?php
/**
* 文件描述: 对控制器的方法合法性做判断，并创建相应控制器，并使方法执行
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月15日 下午1:53:06
* @version 1.0.0
* @copyright  CopyRight
*/
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
    
    
    /**
    * 描述: 判断控制器和方法合法性，并存储
    * @date: 2016年4月15日 下午2:10:54
    * @author: xinbingliang <709464835@qq.com>
    * @return:
    */
    function CheckController(){
        $controller = ucwords($this->register->GetValue('controller'));
        //控制器不在被允许的行列则设置默认的控制器(也可以跳转到错误页面)
        if(!in_array($controller, $this->controllerArray)){
            $this->register->SetValue('controller', 'Index');
            $controller = 'Index';
        }
        $this->controller = $controller;
        
        //控制器中的方法是否被允许，并将首字母转化为小写
        if(!in_array(ucwords($this->register->GetValue('action')), $this->pathMessage[$controller])){
            $this->register->SetValue('action', 'Index');
            $action = 'Index';
        }else{
            $action = ucwords($this->register->GetValue('action'));
        }
        $this->action = $action;
/*         echo $controller.'<br/>';
        echo $action; */
    }
    
    /**
    * 描述： 创建控制器对象，并直接执行相应方法
    * 
    * @author xinbingliang
    * @date 2016年4月15日下午2:09:37
    * @version v1.0.0
    */
    function CreateControllerObj(){
        $controlName = '\\App\\Controller\\'.$this->controller;
        //创建控制器
        $controlObj = new $controlName();
        $action = $this->action;
        //执行控制器中的方法
        $controlObj->$action();
    }
    
    
}

?>
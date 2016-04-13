<?php
namespace App\Controller;
/**
* 文件描述: 所有控制器都必须继承的父类
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月10日 上午9:10:16
* @version 1.0.0
* @copyright  CopyRight
*/
abstract class Controller{
    //所有控制器必须有默认的index方法
    abstract function Index();
}
?>
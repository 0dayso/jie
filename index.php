<?php
/**
* 文件描述: 整个程序的唯一入口
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月9日 上午8:29:41
* @version 1.0.0
* @copyright  CopyRight
*/
header("Content-type: text/html; charset=utf-8");
//入口文件的位置作为根路径
define("ROOT", str_replace('\\', '/', __DIR__).'/');
//加载自动加载函数
require_once ROOT.'Xin/Autoload.php';
//使用自动加载函数
spl_autoload_register('\\Xin\\Autoload::MyLoad');
//初始化注册器
$register = Xin\Register::Instance();
//将数据库操作函数存入注册器中
$register->SetValue('db', Xin\DBFactory::GetDB());
//获得控制器,动作和数据并存入注册器中
$pathInfo = Xin\Pathinfo::GetInfo();
var_dump($pathInfo);
$register->SetValue('controller', $pathInfo['controller']);
$register->SetValue('action', $pathInfo['action']);
$register->SetValue('data', $pathInfo['data']);
//命令分发和相应的跳转


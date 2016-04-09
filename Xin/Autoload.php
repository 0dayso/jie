<?php
namespace Xin;
/**
* 文件描述: 自动载入调用的类
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月9日 上午8:44:13
* @version 1.0.0
* @copyright  CopyRight
*/
class Autoload{
    static function MyLoad($class){
        $file = ROOT.str_replace('\\', '/', $class).'.php';
        require_once $file;
    }
}
?>
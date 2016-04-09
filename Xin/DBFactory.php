<?php
namespace Xin;

/**
* 文件描述: 针对以后可能对数据库访问方式的扩展,使用工厂方法来避免以后的变更
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月9日 下午8:56:56
* @version 1.0.0
* @copyright  CopyRight
*/
class DBFactory{
    private static $db = NULL;    
    static function GetDB(){
        if(empty(self::$db)){
            self::$db = \Xin\DB\ThePDO::MyConnect();
        }
        return self::$db;
    }
}

?>
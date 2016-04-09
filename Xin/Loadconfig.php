<?php
namespace Xin;
/**
* 文件描述: 对配置文件的自动加载并使配置项像数组一样访问
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月9日 下午1:45:54
* @version 1.0.0
* @copyright  CopyRight
*/
class Loadconfig implements \ArrayAccess{
    private $path;
    private $configs;
    
    /**
    * 描述: 指定被加载配置文件的位置
    * @date: 2016年4月9日 下午1:49:36
    * @author: xinbingliang <709464835@qq.com>
    * @param: $path 配置文件路径
    * @return:
    */
    function __construct($path){
        $this->path = $path;
    }
    
    //赋值
    function offsetSet($offset, $value){
        $this->configs[$offset] = $value;
    }
    
    //判断键是否存在
    function offsetExists($offset){
        isset($this->configs[$offset]);
    }
    
    //删除键值
    function offsetUnset($offset){
        unset($this->configs[$offset]);
    }
    
    /**
    * 描述:
    * @date: 2016年4月9日 下午1:50:38
    * @author: xinbingliang <709464835@qq.com>
    * @param: $offset 指定要加载文件的名称，并且以此为key
    * @return: 返回的数据是配置项的数组形式
    */
    function offsetGet($offset){
        if(!isset($this->configs[$offset])){
            $file = $this->path.'/'.$offset.'.php';
            $this->configs[$offset] = require_once $file;
        }
        return $this->configs[$offset];
    }
}

?>
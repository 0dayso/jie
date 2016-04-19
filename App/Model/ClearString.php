<?php
namespace App\Model;
/**
* 文件描述: 字符串处理类，用来过滤字符串
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月19日 下午2:04:30
* @version 1.0.0
* @copyright  CopyRight
*/
class ClearString{
    /**
    * 描述: 判断字符串是否为空
    * @date: 2016年4月19日 下午2:09:15
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    static function IsNone($string){
        //判断是否没有设置或者已经为空
        $string = empty($string)?null:$string;
        
        //去除两边空格，再判断是否为空
        if($string != null){
            $string = trim($string);
            $string = empty($string)?null:$string;
        }
        
        //最后返回处理后的数据
        return $string;
    }
    
    
    /**
    * 描述:  过滤掉特殊的字符
    * @date: 2016年4月19日 下午2:21:36
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    static function ReturnClear($string){
        //删除反斜线，并转将HTML标签转化为实体
        return htmlspecialchars(stripcslashes($string));
    }
    
}

?>
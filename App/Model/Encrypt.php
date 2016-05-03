<?php
/**
* 文件描述: 专门用来对数据进行加密
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月15日 下午3:45:04
* @version 1.0.0
* @copyright  CopyRight
*/
namespace App\Model;

class Encrypt{
    static function md5_md5($password){
        //先进行crypt加密然后并加盐
        $password = md5($password.'5db1638');
        //进行md5加密
        $password = md5($password);
        return $password;
    }
}

?>
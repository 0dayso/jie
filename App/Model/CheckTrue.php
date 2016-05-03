<?php
/**
* 文件描述: 远程获取用户信息 并将数据存放在控制器的数组中
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月15日 下午8:20:42
* @version 1.0.0
* @copyright  CopyRight
*/
namespace App\Model;

class CheckTrue{
    //传递进来的是控制器对象
    static function GetMessage(){
        $ch = curl_init();
        $url = 'http://apis.baidu.com/chazhao/idcard/idcard?idcard='.$_SESSION['reg']['idcard'];
        $header = array(
            'apikey: 444d745792217140b6c31353b220911e',
        );
        // 添加apikey到header
        curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 执行HTTP请求
        curl_setopt($ch , CURLOPT_URL , $url);
        $res = curl_exec($ch);
        
        $data = json_decode($res, true);
        if($data['error'] != 0){
            return "身份证错误";
        }else{
            //对身份证号码加密
            $_SESSION['reg']['idcard'] = Encrypt::md5_md5($_SESSION['reg']['idcard']);
            //存入身份证上的地址
            $_SESSION['reg']['idaddress'] = $data['data']['address']; 
            //将生日时间转化为时间戳
            $_SESSION['reg']['birthday'] = $data['data']['birthday'];
            //存入注册时间
            $_SESSION['reg']['time'] = time(); 
            //存入
            $_SESSION['reg']['gender'] = $data['data']['gender'];
            return NULL;
        }
    } 
}

?>
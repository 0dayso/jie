<?php
namespace App\Model;
/**
* 文件描述: 用户信息操作助手类
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月26日 下午10:00:35
* @version 1.0.0
* @copyright  CopyRight
*/

class UserHelp{
    //用户id
    private $userid;
    //存放数据
    private $data;
    
    /**
    * 描述: 获得注册器中要读取用户的信息
    * @date: 2016年4月26日 下午9:57:26
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function __construct(){
        //获得注册器对象
        $register = \Xin\Register::Instance(); 
        $data = $register->GetValue('data');
        $this->userid = $data['userid']; 
        
        //判断是完整信息还是部分信息
    }
    
    /* 
     * 问题对数据商品信息的读取会在多个地方都会使用到，
     * 应该切分成更小的数据类
     *  
     *  */
    
    /**
    * 描述: 获取用户完整信息
    * @date: 2016年4月26日 下午10:26:44
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function Intact(){
        //获得数据库对象
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        //组装要查询的字段
        $queryArray = array('userid', 'username', 'birthday', 'userimg', 'gender', 'email', 'qq', 'address', 'tel', 'point');
        $this->data = $db->FetchOne('user', array('userid'=>$this->userid), $queryArray);
    }
    

    /**
    * 描述: 获取用户部分信息
    * @date: 2016年4月26日 下午10:29:35
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function Part(){
    }
    
    
    /**
    * 描述: 统一返回数据信息
    * @date: 2016年4月27日 上午9:08:10
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return: 返回用户信息数据
    */
    function ReturnUserMessage(){
        return $this->data;
    }
}

?>
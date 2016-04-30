<?php
namespace Admin\Model;
/**
* 文件描述: 管理员信息操作助手
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月29日 下午9:27:08
* @version 1.0.0
* @copyright  CopyRight
*/

class AdminHelp{
    /**
    * 描述: 从数据库读取用户信息,
    * @date: 2016年4月29日 下午9:27:33
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return: $data 所有管理员的信息
    */    
    static function Index(){
        //用户名和密码对比
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $data = $db->FetchAll('admin');
        return $data;
    }
    
    /**
    * 描述: 根据adminid获取该用户信息
    * @date: 2016年4月29日 下午10:20:50
    * @author: xinbingliang <709464835@qq.com>
    * @param: $arr 字段和值组成的查询条件
    * @return:
    */
    static function GetAdmin($arr){
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $data = $db->FetchOne('admin', $arr, array('adminid', 'adminname', 'email'));
        return $data;
        
    }
    
}

?>
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
    
    
    /**
    * 描述: 管理员数据提交
    * @date: 2016年4月30日 上午10:17:44
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    static function SubAdmin(){
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        //字符串过滤
        $adminname = \App\Model\ClearString::IsNone($_POST['adminname']);
        $adminname = \App\Model\ClearString::ReturnClear($adminname);
        $email  = \App\Model\ClearString::IsNone($_POST['email']);
        $email = \App\Model\ClearString::ReturnClear($email);
        $adpassword = \App\Model\ClearString::IsNone($_POST['adpassword']);
        $adpassword = \App\Model\ClearString::ReturnClear($adpassword);

        
        //判断邮箱是否合法
        $reg = "/^[0-9a-zA-Z]+(?:[_-][a-z0-9-]+)*@[a-zA-Z0-9]+(?:[-.][a-zA-Z0-9]+)*.[a-zA-Z]+$/i";
        if(!preg_match($reg,$email)){
            return;
        }
        
        //判断密码长度是否大于八个
        if(strlen($adpassword) < 8){
            return ;
        }
        //密码加密
        $adpassword = \App\Model\Encrypt::md5_crypt($adpassword);
        
        //任意一项为空都直接返回
        if(empty($adminname) || empty($email) || empty($adpassword)){
            return;
        }
        
        //根据是否存在adminid,判断是添加还是修改
        if(empty($_POST['adminid'])){
            $array = array('adminname'=>$adminname, 'email'=>$email, 'adpassword'=>$adpassword);
            $db->Insert('admin', $array);
        }else{
            $id = $_POST['adminid'];
            $array = array('adminname'=>$adminname, 'email'=>$email, 'adpassword'=>$adpassword);
            $where =  'adminid = '.$_POST['adminid'];
            $db->Update('admin', $array, $where);
        }
    }
}

?>
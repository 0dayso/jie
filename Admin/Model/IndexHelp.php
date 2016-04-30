<?php
namespace Admin\Model;
/**
* 文件描述: 后台首页助手
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月29日 下午5:06:58
* @version 1.0.0
* @copyright  CopyRight
*/
class IndexHelp{
    static function Login(){
        //过滤数据
        $username = \App\Model\ClearString::IsNone($_POST['username']);
        $username =\App\Model\ClearString::ReturnClear($username);
        $password = \App\Model\ClearString::IsNone($_POST['password']);
        $password = \App\Model\ClearString::ReturnClear($password);
        //加密
        $password = \App\Model\Encrypt::md5_crypt($password); 
        $code = \App\Model\ClearString::IsNone($_POST['code']);
        $code = \App\Model\ClearString::ReturnClear($code);
        //验证码对比
        if($_SESSION['code'] != $code){
            header("Location: http://localhost/jie/admin.php");
        } 
        //用户名和密码对比
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $where = 'adminname = "'.$username.'" and adpassword = "'.$password.'"';
        $data = $db->FetchAll('admin', $where); 
        
        if(!empty($data)){
            //用户信息写session
            $_SESSION['adminname'] = $data[0]['adminname'];
            $_SESSION['adminid'] = $data[0]['adminid'];
        }
        
        header("Location: http://localhost/jie/admin.php");
    }   
}
?>
<?php
/* 应该在所有数据提的时候再进行一次 */
namespace App\Controller;

class Index{
    /**
    * 描述: 刚刚进入首页
    * @date: 2016年4月16日 下午9:26:49
    * @author: xinbingliang <709464835@qq.com>
    * @return:
    */
    function Index(){
        include ROOT.'App/view/index.php'; 
    }
    
    
    /**
    * 描述: 点击注册时执行
    * @date: 2016年4月16日 下午9:27:28
    * @author: xinbingliang <709464835@qq.com>
    * @return:
    */
    function Reg(){
        $checkObj = \App\Model\CheckUserMessage::GetSelf();
        $message = $checkObj->CheckReg();
        if($message == NULL){
            $checkObj->getMessage();
            var_dump($_SESSION['user']);
        }
    }
    
    
    /**
    * 描述: 注册验证身份证
    * @date: 2016年4月16日 下午9:29:26
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function CheckIdcard(){
        $idcard = empty($_POST['idcard'])?NULL:$_POST['idcard'];
        $_SESSION['reg']['idcard'] = $idcard;
        $checkObj = \App\Model\CheckUserMessage::GetSelf();
        $message = $checkObj->CheckIdcard();
        echo empty($message)?NULL:$message;
    }
    
    
    /**
    * 描述: 注册时验证用户名
    * @date: 2016年4月17日 上午9:00:34
    * @author: xinbingliang <709464835@qq.com>
    * @return:
    */
    function CheckName(){
        $username = empty($_POST['username'])?null:$_POST['username'];
        $_SESSION['reg']['username'] = $username;
        $checkObj = \App\Model\CheckUserMessage::GetSelf();
        $message = $checkObj->CheckUsername();
        echo empty($message)?NULL:$message; 
    }
    
    /**
    * 描述: 注册时验证密码
    * @date: 2016年4月17日 上午9:00:57
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function CheckPassword(){
       $password = empty($_POST['password'])?null:$_POST['password'];
       $_SESSION['reg']['password'] = $password;
       $checkObj = \App\Model\CheckUserMessage::GetSelf();
       $message = $checkObj->CheckEmpty('password');
       return empty($message)?NULL:'不能为空';
    }
    
    /**
    * 描述: ajax邮件验证
    * @date: 2016年4月16日 下午9:30:29
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function CheckEmail(){
        $_SESSION['reg']['email'] = $_POST['email'];
        $checkObj = \App\Model\CheckUserMessage::GetSelf();
        $message = $checkObj->CheckEmail();
        /* var_dump($message); */
        echo empty($message)?NULL:$message; 
    }
    
    
    /**
    * 描述: 用户点击登录后的登录验证
    * @date: 2016年4月16日 下午9:31:08
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function Log(){
        //最后再检查一次密码和邮箱
        $checkObj = \App\Model\CheckUserMessage::GetSelf();
        $logMessage = $checkObj->CheckLog();
        if(!empty($logMessage)){
            //重新跳转到首页
            echo "<script language='javascript'>";
            echo " location='index.php';";
            echo "</script>";
        }else{
            $checkObj->getMessage();
            var_dump($_SESSION['user']);
        }
    }

    /**
    * 描述: 登录时邮箱验证
    * @date: 2016年4月17日 上午9:02:44
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function LogEmail(){
        $_SESSION['reg']['email'] = $_POST['email'];
        $checkObj = \App\Model\CheckUserMessage::GetSelf();
        $message = $checkObj->CheckEmail();
        if($message == '邮件已经被注册'){
            echo NULL;
        }else{
            echo "您没有注册";
        }
    }
    
    /**
    * 描述: 登录时密码验证
    * @date: 2016年4月17日 上午9:03:26
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function LogPassword(){
        $_SESSION['reg']['password'] = $_POST['password'];
        $checkObj = \App\Model\CheckUserMessage::GetSelf();
        $message = $checkObj->CheckPassword();
        if(empty($message)){
            echo null;
        }else{
            echo $message;
        }
    }

}
?>
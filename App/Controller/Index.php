<?php
/* 应该在所有数据提的时候再进行一次 */
namespace App\Controller;

class Index{
    /**
    * 描述: 进入首页
    * @date: 2016年4月16日 下午9:26:49
    * @author: xinbingliang <709464835@qq.com>
    * @return:
    */
    function Index(){
        $showgoods = new Show();
        $showgoods->Index();
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
            $this->Index();
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
        //清除原来的设置
        $_SESSION['reg']['idcard'] = NULL;
        /* $idcard = empty($_POST['idcard'])?NULL:$_POST['idcard']; */
        //清理两边空格
        $idcard = \App\Model\ClearString::IsNone($_POST['idcard']);
        //去除特殊符号
        $idcard = \App\Model\ClearString::ReturnClear($idcard);
        $_SESSION['reg']['idcard'] = $idcard;
        $checkObj = \App\Model\CheckUserMessage::GetSelf();
        $message = $checkObj->CheckIdcard();
        if(empty($message)){
            $returnarr = array('errrno'=>0);
        } else {
          $returnarr = array('errorno'=>1, 'errormess'=>$message);  
        }
        echo json_encode($returnarr);
    }
    
    
    /**
    * 描述: 注册时验证用户名
    * @date: 2016年4月17日 上午9:00:34
    * @author: xinbingliang <709464835@qq.com>
    * @return:
    */
    function CheckName(){
        $username = \App\Model\ClearString::IsNone($_POST['username']);
        $username = \App\Model\ClearString::ReturnClear($username);
        $_SESSION['reg']['username'] = $username;
        $checkObj = \App\Model\CheckUserMessage::GetSelf();
        $message = $checkObj->CheckUsername();
        if(empty($message)){
            $errarr = array('errno'=>0);
        } else{
            $errarr = array('errno'=>1, 'errormess'=>$message);
        }
        echo json_encode($errarr);
    }
    
    /**
    * 描述: 注册时验证密码
    * @date: 2016年4月17日 上午9:00:57
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function CheckPassword(){
       $password = \App\Model\ClearString::IsNone($_POST['password']);
       $password = \App\Model\ClearString::ReturnClear($password);
       $_SESSION['reg']['password'] = $password;
       $checkObj = \App\Model\CheckUserMessage::GetSelf();
       $message = $checkObj->CheckEmpty('password');
        if(empty($message)){
            $errarr = array('errno'=>0);
        } else{
            $errarr = array('errno'=>1, 'errormess'=>$message);
        }
        echo json_encode($errarr);
    }
    
    /**
    * 描述: ajax邮件验证
    * @date: 2016年4月16日 下午9:30:29
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function CheckEmail(){
        //去除空格
        $email = \App\Model\ClearString::IsNone($_POST['email']);
        
        $_SESSION['reg']['email'] = $email;
        $checkObj = \App\Model\CheckUserMessage::GetSelf();
        $message = $checkObj->CheckEmail();
        /* var_dump($message); */
        if(empty($message)){
            $errarr = array('errno'=>'0');
        }else {
            $errarr = array('errno'=>'1', 'errmess'=>$message);
        }
        echo json_encode($errarr);
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
            $this->Index();
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
            $errarr = array('errno'=>'0');
        }else{
            $errarr = array('errno'=>'1', 'errmess'=>'您还没有注册');
        }
        echo json_encode($errarr);
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
            $errarr = array('errno'=>'0');
        }else{
            $errarr = array('errno'=>'1', 'errmess'=>$message);
/*             echo $message; */
        }
        echo json_encode($errarr);
    }

    /**
    * 描述: 退出操作,清除session,回到首页
    * @date: 2016年4月17日 下午3:38:16
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function LogOut(){
        $_SESSION[] = array();
        if(isset($_COOKIE[session_name()])){
            setcookie(session_name(), '', time()-42000, '/');
        }
        session_destroy();
        //回到首页
        //重定向浏览器 
        header("Location: ".INLET); 
        //确保重定向后，后续代码不会被执行 
        exit;
    }
    
    
    /**
    * 描述: 邮件激活活
    * @date: 2016年5月15日 下午7:48:16
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function EnableMail(){
        //获得传递过来的信息
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $data = $register->GetValue('data');
        $enable = $data['enable'];
        $userid = $data['userid'];
        
        //获得该用户对应的激活码
        $ret = $db->FetchOne('user', array('userid'=>$userid), array('enable'));
        if($ret['enable'] == $enable){
            //发送消息告知用户已经激活
            $time = time();
            $coon = '您已经成功的激活!';
            
            $arr = array('userid'=>1, 'chattime'=>$time, 'chatcontent'=>$coon, 'touser'=>$userid);
            $db->Insert('chat', $arr);
            $selfmess = $db->FetchOne('user', array('userid'=>$userid), array('activechat', 'chat'));
            //向获活动项中添加小编用户
            $activechat = $selfmess['activechat'];
            $activearr = explode(',', $activechat);
            array_unshift($activearr, 1);
            $activearr = array_unique($activearr);
            $activestr = join(',', $activearr);
            $activestr = trim($activestr, ',');
            
            $chat = $selfmess['chat'] + 1;
            $db->Update('user', array('chatlist'=>$activestr, 'chat'=>$chat, 'enable'=>0), " userid = {$userid} ");
        }
        
        $this->Index();
    }
    
}
?>
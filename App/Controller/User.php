<?php
namespace App\Controller;
/**
* 文件描述: 用户主页控制器
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月25日 上午9:22:57
* @version 1.0.0
* @copyright  CopyRight
*/
class User{
    function Index(){
        $register = \Xin\Register::Instance();
        
        //创建模型层用户数据助手
        $userHelper = new \App\Model\UserHelp();        
        //得到用户返回数据
        
        //判断获得数据的类型
        $userHelper->Intact();
        $userData = $userHelper->ReturnUserMessage(); 
        //得到评论返回数据
/*         //先获得10 条数据
        $_SESSION['userdisnum'] = 10;
        //分页计数器
        $_SESSION['userdispagenum'] = 0; */
        
        
        $disdata = $userHelper->GetUserDis();

        //得到商品简要信息数据
        
        
/*         var_dump($register);
        exit(); */
        include ROOT.'App/view/top.html';
        echo '<link href="http://localhost/jie/App/View/style/all.css" rel="stylesheet" type="text/css"/>';
        echo '<link href="http://localhost/jie/App/View/style/user.css" rel="stylesheet" type="text/css"/>';
        include ROOT.'App/view/head.html';
        include ROOT.'App/view/user.php';
        include ROOT.'App/view/footer.html';
    }   
    
    
    /**
    * 描述: 修改qq号码
    * @date: 2016年4月27日 下午7:43:32
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function QQChange(){
        $qqstr = \App\Model\ClearString::IsNone($_POST['qqstr']);
        //字符串过滤
        $qqstr = \App\Model\ClearString::ReturnClear($qqstr);
        if(preg_match("/^[1-9][0-9]{4,}$/",$qqstr)) {
            //存入数据库
            $register = \Xin\Register::Instance();
            $db = $register->GetValue('db');
            $userid = $_SESSION['user']['userid'];
            $db->Update('user', array('qq'=>$qqstr), " userid = {$userid}");
            echo $qqstr;
        }else {
            echo 'error';
        }
    }
    
    
    /**
    * 描述: 修改地址
    * @date: 2016年4月27日 下午7:43:49
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function AddChange(){
        $addstr = \App\Model\ClearString::IsNone($_POST['addstr']);
        //字符串过滤
        $addstr = \App\Model\ClearString::ReturnClear($addstr);
        //存入数据库
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $userid = $_SESSION['user']['userid'];
        $db->Update('user', array('address'=>$addstr), " userid = {$userid}");
        echo $addstr;
    }
    
    
    /**
    * 描述: 修改邮箱
    * @date: 2016年4月27日 下午7:44:02
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function EmailChange(){
        $emailstr = \App\Model\ClearString::IsNone($_POST['emailstr']);
        //字符串过滤
        $emailstr = \App\Model\ClearString::ReturnClear($emailstr);
        if(preg_match("/([a-z0-9_\-\.]+)@(([a-z0-9]+[_\-]?)\.)+[a-z]{2,3}/i",$emailstr)) {
            //存入数据库
            $register = \Xin\Register::Instance();
            $db = $register->GetValue('db');
            $userid = $_SESSION['user']['userid'];
            $db->Update('user', array('email'=>$emailstr), " userid = {$userid}");
            echo $emailstr;
        }else {
            echo 'error';
        }
    }
    
    
    /**
    * 描述: 修改电话
    * @date: 2016年4月27日 下午7:44:13
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function TelChange(){
        $telstr = \App\Model\ClearString::IsNone($_POST['telstr']);
        //字符串过滤
        $telstr = \App\Model\ClearString::ReturnClear($telstr);
        if(preg_match("/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/",$telstr)) {
            //存入数据库
            $register = \Xin\Register::Instance();
            $db = $register->GetValue('db');
            $userid = $_SESSION['user']['userid'];
            $db->Update('user', array('tel'=>$telstr), " userid = {$userid}");
            echo $telstr;
        }else {
            echo 'error';
        }
    }
    
    /**
    * 描述: 检查旧密码
    * @date: 2016年4月27日 下午7:44:59
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function CheckPassword(){
        $oldpassword = \App\Model\ClearString::IsNone($_POST['oldpassword']);
        //字符串过滤
        $oldpassword = \App\Model\ClearString::ReturnClear($oldpassword);
        //密码加密 
        $oldpassword= \App\Model\Encrypt::md5_crypt($oldpassword);
        $userid = $_SESSION['user']['userid'];
        
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $data = $db->FetchAll('user', "userid = $userid and password = '{$oldpassword}'");
        if (empty($data)){
            echo "error";
        }else{
            echo "ok";
        }
    }
    
    /**
    * 描述: 更新密码
    * @date: 2016年4月27日 下午8:57:28
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function ChangePassword(){
        $newpassword = \App\Model\ClearString::IsNone($_POST['newpassword']);
        //字符串过滤
        $newpassword = \App\Model\ClearString::ReturnClear($newpassword);
        //密码加密
        $newpassword= \App\Model\Encrypt::md5_crypt($newpassword);
        //存入数据库
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $userid = $_SESSION['user']['userid'];
        $db->Update('user', array('password'=>$newpassword), " userid = {$userid}"); 
        echo 'ok';
    }
    
    
    /**
    * 描述: 提交评论
    * @date: 2016年4月28日 上午7:51:15
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function PushDis(){
        try {
            $udcontent = \App\Model\ClearString::IsNone($_POST['text']);
            //字符串过滤
            $udcontent = \App\Model\ClearString::ReturnClear($udcontent);
            $start = $_POST['startnum'];
            $beuserid = $_SESSION['user']['userid'];
            $udtime = time();
            $touserid = $_SESSION['touserid'];
            $userdiscuss = array('udcontent'=>$udcontent, 'start'=>$start, 'beuserid'=>$beuserid, 'udtime'=>$udtime, 'touserid'=>$touserid);
            //存入数据库
            $register = \Xin\Register::Instance();
            $db = $register->GetValue('db');
            $db->Insert('userdiscuss', $userdiscuss);
            echo "添加平路成功";
        }catch(\Exception $e){
            echo $e->getMessage();
        }
        
    }
    
}
?>
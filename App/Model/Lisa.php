<?php
namespace App\Model;
/**
* 文件描述: 小编用户操作类
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年5月15日 下午3:27:41
* @version 1.0.0
* @copyright  CopyRight
*/
class Lisa{
    /**
     * 描述: 邮件发送类
     * @date: 2016年5月15日 下午2:50:11
     * @author: xinbingliang <709464835@qq.com>
     * @param: $Link 链接
     * @param: $toemail 要发送给谁
     * @return:
     */
    static public function Sendmail($Link, $toemail){
        header("content-type:text/html;charset=utf-8");
        ini_set("magic_quotes_runtime",0);
        /* require 'class.phpmailer.php'; */
        try {
            /* $selmail = */ 
            $mail = new \Xin\PHPMailer(true);
            $mail->IsSMTP();
            $mail->CharSet='UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
            $mail->SMTPAuth   = true;                  //开启认证
            $mail->Port       = 25;
            $mail->Host       = "smtp.163.com";
            $mail->Username   = "15102724518@163.com";
            /*xzl99436621*/
            /*xzl99436621*/
            $mail->Password   = "xzl99436621";
            //$mail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could  not execute: /var/qmail/bin/sendmail ”的错误提示
            $mail->AddReplyTo("15102724518@163.com","mckee");//回复地址
            $mail->From       = "15102724518@163.com";
            $mail->FromName   = "www.jiexiaqu.com";
            /* $to = "709464835@qq.com"; */
            $to = $toemail;
            $mail->AddAddress($to);
            $mail->Subject  = "接下去邮件激活";
            $mail->Body = "<h1>接下去，晒出你的旧物！</h1><br/><br/>接下去邮件激活，点击链接：（<a color=red >{$Link}</a>），你距离成为接下去用户还有最后一步^-^";
            $mail->AltBody    = "您距离成功注册还有异步，点击连接激活!"; //当邮件不支持html时备用显示，可以省略
            $mail->WordWrap   = 80; // 设置每行字符串的长度
            //$mail->AddAttachment("f:/test.png");  //可以添加附件
            $mail->IsHTML(true);
            $mail->Send();
            echo '邮件已发送';
        } catch (\Xin\phpmailerException $e) {
            echo "邮件发送失败：".$e->errorMessage();
        }
    }
    
    
    /**
     * 描述: 向数据库中写邮件激活提示消息
     * @date: 2016年5月15日 下午3:02:59
     * @author: xinbingliang <709464835@qq.com>
     * @param: variable
     * @return:
     */
    static public function MailChat(){
        //获得数据库对象
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        //读取用户id信息
        $touser = $db->FetchOne('user', array('email'=>$_SESSION['reg']['email']), array('userid', 'activechat', 'chat'));
        $time = time();
        $coon = '请登录您的邮箱:'.$_SESSION['reg']['email'].'激活您的账户 ^_^!';
        $arr = array('userid'=>1, 'chattime'=>$time, 'chatcontent'=>$coon, 'touser'=>$touser['userid']);
        $db->Insert('chat', $arr);
        //向获活动项中添加小编用户
        $activechat = $touser['activechat'];
        $activearr = explode(',', $activechat);
        array_unshift($activearr, 1);
        $activearr = array_unique($activearr);
        $activestr = join(',', $activearr);
        $activestr = trim($activestr, ',');
        $chat = $touser['chat'] + 1;
        $where = " userid = {$touser['userid']} ";
        //激活时的标记位
        $enable = \App\Model\Encrypt::md5_md5($_SESSION['reg']['email']);
        //创建激活链接
        $Link = INLET.'index.php/Index/EnableMail&enable='.$enable.'&userid='.$touser['userid'];
        $db->Update('user', array('userid'=>$touser['userid'], 'activechat'=>$activestr, 'chatlist'=>1, 'chat'=>$chat, 'enable'=>$enable), $where);
        
        self::Sendmail($Link, $_SESSION['reg']['email']);
    }
    
    /**
    * 描述: 系统向用户提示消息
    * @date: 2016年5月16日 上午7:36:16
    * @author: xinbingliang <709464835@qq.com>
    * @param: $touserid 要被通知的用户
    * @param: $mess 给用户的提示消息
    * @return:
    */
    static function SystemChat($touserid, $mess){
        //获得数据库对象
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        //读取用户id信息
        $touser = $db->FetchOne('user', array('userid'=>$touserid), array('activechat', 'chat', 'chatlist'));
        //添加系统帐号活动
        $activechat = $touser['activechat'];
        $activearr = explode(',', $activechat);
        array_unshift($activearr, 1);
        $activearr = array_unique($activearr);
        $activestr = join(',', $activearr);
        $activestr = trim($activestr, ',');
        //聊天对象中添加系统用户
        $cahtList = $touser['chatlist'];
        $chatListarr = explode(',', $cahtList);
        array_unshift($chatListarr, 1);
        $chatListarr = array_unique($chatListarr);
        $chatListstr = join(',', $chatListarr);
        $chatListstr = trim($chatListstr, ',');
        //活动聊天记录加一
        $chat = $touser['chat'] + 1;
        $where = " userid = {$touserid} ";
        //写入数据库
        $db->Update('user', array('activechat'=>$activestr, 'chatlist'=>$chatListstr, 'chat'=>$chat, ), $where);
        //将消息写入数据库
        $time = time();
        $arr = array('userid'=>1, 'chattime'=>$time, 'chatcontent'=>$mess, 'touser'=>$touserid);
        $db->Insert('chat', $arr);
    }
}
?>
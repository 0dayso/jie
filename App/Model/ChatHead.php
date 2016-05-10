<?php
namespace App\Model;
/**
* 文件描述: 用户聊天操作类
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年5月7日 下午2:51:03
* @version 1.0.0
* @copyright  CopyRight
*/

class ChatHead{
    /**
    * 描述: 读取聊天记录的用户列表
    * @date: 2016年5月7日 下午8:00:14
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    static function Index(){
        /* return $_SESSION['user']['userid']; */
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $userListString = self::GetChatList();
        if(!empty($userListString)){
            $userListString = $userListString['chatlist'];
            $userListArray = explode(',', $userListString);
            /* return $userListString; */
            //根据用户列表获得各个用户基本信息
            $userList = array();
            
            foreach ($userListArray as $key => $value){
                $where = array('userid'=>$value);
                $data = $db->FetchOne('user', $where, array('userid', 'username', 'userimg'));
                $userList[$key]['userid'] = $data['userid'];
                $userList[$key]['username'] = $data['username'];
                $userList[$key]['userimg'] = $data['userimg'];
            } 
            
            //获得与最后一个聊天的最近10条聊天记录
            $num = count($userList)-1;
            $last = $userList[0];
            $touser = $last['userid'];
            $userList['chat'] = self::GetChat($touser, 0);
            return  $userList;
        }else{
            return null;
        }
    }
    
    
    /**
    * 描述: 获得当前用户的对话列表
    * @date: 2016年5月7日 下午8:03:36
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    static function GetChatList(){
        $userid = $_SESSION['user']['userid'];
        //获得用户列表
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $where = array('userid'=>$userid);
        $userListString = $db->FetchOne('user', $where, array('chatlist'));
       /*  file_put_contents(ROOT.'message.txt', join(',', $userListString)); */
        return $userListString;
    }

    
    /**
    * 描述: 读取聊天记录 
    * @date: 2016年5月7日 下午8:00:50
    * @author: xinbingliang <709464835@qq.com>
    * @param: $touser 聊天的对象id
    * @param: $start 记录开始的位置
    * @return:
    */
    static function GetChat($touser, $start=0){
        //获取活动的对话对象
        
        //获取聊天对象的消息记录数量，本次读取聊天数据条数为该值数量
        
        
        
        
        
        $userid = $_SESSION['user']['userid'];
        //获得用户列表
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $chatHistory = $db->FetchAll('chat', " (userid = {$userid} and touser = {$touser}) or (userid = {$touser} and touser = {$userid}) ", NUll, " limit {$start}, 10 ", ' order by chattime desc ');
        //将已经读取消息的标记位设定为已读
        if(!empty($chatHistory)){
            $chatHistory = array_reverse($chatHistory);
        }
        return $chatHistory;
    }
    
    
    /**
    * 描述: 修改当前对话列表的对象
    * @date: 2016年5月7日 下午8:06:13
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    static function ChangeList($arr){
        $str = join(',', $arr);
        $str = trim($str, ',');
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $arr = array('chatlist'=>$str);
        $db->Update('user', $arr, " userid = {$_SESSION['user']['userid']} ");
    }
    
    
    /**
    * 描述: 向数据库中写数据 
    * @date: 2016年5月8日 上午10:25:53
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    static function PushChat(){
        $touserid = $_POST['touserid'];
        $chat = $_POST['chat'];
        //判断是否为空
        $touserid = \App\Model\ClearString::IsNone($touserid);
        $touserid = \App\Model\ClearString::ReturnClear($touserid);
        $chat = \App\Model\ClearString::IsNone($chat);
        $chat = \App\Model\ClearString::ReturnClear($chat);
        if(!empty($touserid) && !empty($chat)){
            //组装插入点数据
            $time = time();
            $array = array(
                'userid'=>$_SESSION['user']['userid'],
                'chattime'=>$time,
                'chatcontent'=>$chat,
                'touser'=>$touserid
            );
            //获得数据库对象
            $register = \Xin\Register::Instance();
            $db = $register->GetValue('db');
            //存入数据库
            $db->Insert('chat', $array);
            $array = array('date'=>date('H:i', $time), 'cont'=>$chat);
            self::ChatFalgChange($touserid); 
            return $array;
        }
    }
    
    
    /**
    * 描述: 向用户表中增加未读聊天数目，向未读对象表中添加用户用户id
    * @date: 2016年5月8日 下午8:05:41
    * @author: xinbingliang <709464835@qq.com>
    * @param: $touserid 被操作的用户id
    * @return:
    */
    static function ChatFalgChange($touserid){
        //获得数据库对象
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        //获得原来的数据
        $data = $db->FetchOne('user', array('userid'=>$touserid), array('activechat', 'chat'));
        //添加当前聊天对象到最前
        $arr = explode(',', $data['activechat']);
        array_unshift($arr, $_SESSION['user']['userid']);
        //删除数组中的重复部分
        $arr = array_unique($arr); 
        $activechat = join(',', $arr);
        //将未读取数据加一
        $num = $data['chat']+1;
        $array = array('activechat'=>$activechat, 'chat'=>$num);
        $db->Update('user', $array, " userid = $touserid ");
    }
     
}

?>
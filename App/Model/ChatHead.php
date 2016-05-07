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
    static function Index(){
        $userid = $_SESSION['user']['userid'];
        //获得用户列表
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $where = array('userid', $userid);
        $userListString = $db->FetchOne('user', $where, array('chatlist'));
        if(!empty($userListString)){
            $userListString = $userListString['chatlist'];
            $userListArray = explode(',', $userListString);
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
            $last = $userList[$num];
            $touser = $last['userid'];
            $userList['chat'] = self::GetChat($touser, 0);
            return  $userList;
        }else{
            return null;
        }
        
    }
    
    static function GetChat($touser, $start){
        $userid = $_SESSION['user']['userid'];
        //获得用户列表
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $chatHistory = $db->FetchAll('chat', " (userid = {$userid} and touser = {$touser}) or (userid = {$touser} and touser = {$userid}) ", NUll, " limit {$start}, 10 ", ' order by chattime desc ');
    }
    
    
}

?>
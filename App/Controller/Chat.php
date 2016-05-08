<?php
namespace App\Controller;
/**
* 文件描述: 聊天消息控制器
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年5月7日 上午10:36:44
* @version 1.0.0
* @copyright  CopyRight
*/
class Chat{
    /**
    * 描述: 进入页面的时读取聊天对象的列表，和最后的聊天记录
    * @date: 2016年5月7日 下午2:27:56
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function Index(){
       $data = \App\Model\ChatHead::Index();
       echo json_encode($data);
    }
    
    
    /**
    * 描述: 前端请求货物物主是否已经是自己的聊天对象，是则重排，不是则添加
    * @date: 2016年5月7日 下午7:54:11
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function AddChatUser(){
        $touserid = $_POST['touserid'];
        //获得已有的聊天列表
        $chatlist = \App\Model\ChatHead::GetChatList();
        $ListString = $chatlist['chatlist'];
        $chatArray = explode(',', $ListString);
        //当前聊天对象添加到数组最开始部分
        array_unshift($chatArray, $touserid);
        //删除数组中的重复部分
        $chatArray = array_unique($chatArray); 
        $str = \App\Model\ChatHead::ChangeList($chatArray);
    }
    
    
    /**
    * 描述: 聊天信息入口
    * @date: 2016年5月8日 上午9:52:11
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function PushChat(){
        $return = $pushChatFlag = \App\Model\ChatHead::PushChat();
        echo json_encode($return);
    }
    
    
    /**
    * 描述: 
    * @date: 2016年5月8日 下午2:46:26
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    
}

?>
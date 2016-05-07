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
    
    
    
    //得到对方的userid
    
    //得到自己的userid
    
    //得到聊天的内容
    
    //读取已经有的聊天对象
    
    //向聊天对象字段中添加聊天对象
    
}

?>
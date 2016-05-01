<?php
namespace Admin\Controller;
/**
* 文件描述: 后台用户管理
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月30日 上午11:25:37
* @version 1.0.0
* @copyright  CopyRight
*/
class TubeUser{
    /**
    * 描述: 用户展示页面
    * @date: 2016年4月30日 上午11:25:55
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function Index(){
        //获得用户数据
        $data = \Admin\Model\Userhelp::GetUser();
        $count = count($data);
        /* var_dump($data); */
        include ROOT.'Admin/View/user.php';
        var_dump($_SESSION);
    }
    
    /**
    * 描述: 向上获得更多的数据
    * @date: 2016年4月30日 下午4:37:31
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function PreUser(){
        $num = $_SESSION['userallnum'];        
        $page = $_SESSION['userpage'];
        if($page > 0){
            $start = ($page - 1)*1;
            --$_SESSION['userpage'];
            $data = \Admin\Model\Userhelp::GetData($start, 1);
            echo json_encode($data);
        }
    }
    
    
    /**
    * 描述: 向下获得更多数据
    * @date: 2016年4月30日 下午4:37:54
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function NexUser(){
        $num = $_SESSION['userallnum'];
        $page = $_SESSION['userpage'];
        $start = ++$page*1;
        
        if($start <= $num){
            ++$_SESSION['userpage'];
            $data = \Admin\Model\Userhelp::GetData($start, 1);
            echo json_encode($data);
        }
    }
    
    
    /**
    * 描述: 用户处理操作
    * @date: 2016年5月1日 上午10:06:16
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function UserTube(){
        $userid_action = \Admin\Model\Userhelp::UserData();
        var_dump($userid_action);
        var_dump($_SESSION);
        include ROOT.'Admin/View/enterpassword.html';
    }
    
    
    /**
    * 描述: 管理员确定管理操作
    * @date: 2016年5月1日 上午10:31:29
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function SuerTubUser(){
        $message = \Admin\Model\Userhelp::Adminhadle();
        //跳转到管理用户管理首页
        $this->Index();
    }
    
}

?>
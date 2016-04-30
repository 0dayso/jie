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
    * 描述: 用户删除操作
    * @date: 2016年4月30日 下午5:21:35
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function UserDel(){
        
    }
    
    
    /**
    * 描述: 用户锁定操作
    * @date: 2016年4月30日 下午5:22:05
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function UserLock(){
        
    }
    
    /**
    * 描述: 用户解锁
    * @date: 2016年4月30日 下午5:22:53
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function UserUnlock(){
        
    }
    
}

?>
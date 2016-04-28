<?php
namespace App\Controller;

class UserMore{
    /**
     * 描述: 向上加载更多评论
     * @date: 2016年4月28日 下午3:24:45
     * @author: xinbingliang <709464835@qq.com>
     * @param: variable
     * @return:
     */
    function PreDis(){
        $page = $_SESSION['userdispage'];
        if($page > 0){
            //获得数据库对象
            $start = ($page - 1) * 10;
            $data = \App\Model\UserHelp::DisHelp($start);
            echo json_encode($data);
            $_SESSION['userdispage'] = $_SESSION['userdispage'] - 1;
        }else{
            return null;
        }
    }
    
    
    /**
     * 描述: 向下加载更多
     * @date: 2016年4月28日 下午3:25:59
     * @author: xinbingliang <709464835@qq.com>
     * @param: variable
     * @return:
     */
    function NexDis(){
        $page = $_SESSION['userdispage'];
        $allpage = ceil($_SESSION['userdisnum']/10);
        if($page < $allpage){
            //获得数据库对象
            $start = ($page + 1) * 10;
            $data = \App\Model\UserHelp::DisHelp($start);
            echo json_encode($data);
            $_SESSION['userdispage'] = $_SESSION['userdispage'] + 1;
        }else{
            return null;
        }
    }
    
    
    /**
    * 描述: 向上加载更多商品
    * @date: 2016年4月28日 下午3:32:25
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function PreGoods(){
        $page = $_SESSION['goodpage'];
        if($page > 0){
            //获得数据库对象
            $start = ($page - 1) * 6;
            $data = \App\Model\UserHelp::GoodsHelp($start);
            echo json_encode($data);
            $_SESSION['goodpage'] = $_SESSION['goodpage'] - 1;
        }else{
            return null;
        }
    }
    
    
    /**
    * 描述: 向下加载更多
    * @date: 2016年4月28日 下午3:32:53
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function NexGoods(){
        $page = $_SESSION['goodpage'];
        $allpage = ceil($_SESSION['goodpageall']/6);
        if($page < $allpage){
            //获得数据库对象
            $start = ($page + 1) * 6;
            $data = \App\Model\UserHelp::GoodsHelp($start);
            echo json_encode($data);
            $_SESSION['goodpage'] = $_SESSION['goodpage'] + 1;
        }else{
            return null;
        }
    }
    
}

?>
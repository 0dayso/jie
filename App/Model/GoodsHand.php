<?php
namespace App\Model;
/**
* 文件描述: 商品评论信息
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月23日 下午8:13:16
* @version 1.0.0
* @copyright  CopyRight
*/

class GoodsHand{
    /**
    * 描述: 进入时获得用户信息最多10条
    * @date: 2016年4月23日 下午8:13:32
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    static function Index(){
        //获得注册器
        $register = \Xin\Register::Instance();
        //获得查询的物品id
        $key = $register->GetValue('data');
        $goodsid = $key['gid'];
        //使用数据库
        $db = $register->GetValue('db');
        $all = $db->FetchAll('goodsdiscuss', $where=" goodsid =  $goodsid", NULL, 'limit 0, 10', $desc=' order by gdtime desc');
        $count = count($all);
        //记录已经获取数据量
        $_SESSION['goodsdiscuss'] = $count; 
        //循环对数据进行添加
        for ($i=0; $i < $count; $i++){
            $all[$i]['gdtime'] = date('Y-m-d H:i:s', $all[$i]['gdtime']);
            //根据用户id获得用户的姓名和头像
            $userid = $all[$i]['userid'];
            $data = $db->FetchOne('user',  array('userid'=>$userid),array('username', 'userimg'));
            $username = $data['username'];
            $userimg = INLET.'headimg/'.$data['userimg'];
            //根据被回复用户id获得用户的姓名
            $touserid =  $all[$i]['touserid'];
            $tousername = null;
            if($touserid != 0){
                $data = $db->FetchOne('user',  array('userid'=>$userid),array('username'));
                $tousername = $data['username'];
            }
            //插入到数组中
            $all[$i]['username'] = $username;
            $all[$i]['userimg'] = $userimg;
            $all[$i]['tousername'] = $tousername;
        }        
        return $all;
    } 
    
    /**
    * 描述: 获取更多评论
    * @date: 2016年4月23日 下午8:49:36
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    
    
}

?>
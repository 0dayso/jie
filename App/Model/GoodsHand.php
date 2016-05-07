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
    * 描述: 评论的获取方法
    * @date: 2016年4月24日 下午2:55:42
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    static function get($num = 0){
        //页数
        $_SESSION['goodpage'] = $num;       
        //获得注册器
        $register = \Xin\Register::Instance();
        //获得查询的物品id
        $key = $register->GetValue('data');
        $goodsid = empty($key)?$_SESSION['goods']['goodsid']:$key['gid'];
        //使用数据库
        $db = $register->GetValue('db');
        
        $data = $db->FetchAll('goodsdiscuss', $where=" goodsid =  $goodsid", NULL, NULL, NULL);
        $_SESSION['goodpageall'] = ceil(count($data)/10)-1;  
        
        
        $start = $_SESSION['goodpage']*10;
        $all = $db->FetchAll('goodsdiscuss', $where=" goodsid =  $goodsid", NULL, "limit  $start, 10", $desc=' order by gdtime desc');
        $count = count($all);
        $_SESSION['goodsdiscuss'] = $count;
        //循环对数据进行添加
        for ($i=0; $i < $count; $i++){
            $all[$i]['gdtime'] = date('m-d H:i', $all[$i]['gdtime']);
            //当前登录用户数据，根据用户id获得用户的姓名和头像
            $tuserid = $all[$i]['userid'];
            $data = $db->FetchOne('user',  array('userid'=>$tuserid),array('username', 'userimg'));
            $tusername = $data['username'];
            $tuserimg = INLET.'headimg/'.$data['userimg'];
            //根据被回复用户id获得用户的姓名
            $touserid =  $all[$i]['touserid'];
            $tousername = null;
            if($touserid != 0){
                $data = $db->FetchOne('user',  array('userid'=>$touserid),array('username'));
                $tousername = $data['username'];
            }
            //插入到数组中
            $all[$i]['username'] = $tusername;
            $all[$i]['userimg'] = $tuserimg;
            $all[$i]['tousername'] = $tousername;
        }
        /*          var_dump($all);
         exit();   */
        return $all;
    }
    
}

?>
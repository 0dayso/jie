<?php
namespace App\Model;
/**
* 文件描述: 用户获得货物的方式
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年5月17日 下午2:40:15
* @version 1.0.0
* @copyright  CopyRight
*/
class WantGoods{
    /**
    * 描述: 获得商品的支付方式
    * @date: 2016年5月17日 下午3:31:41
    * @author: xinbingliang <709464835@qq.com>
    * @param: $goodsid 商品的id号
    * @return:
    */         
    static function GetPayType($goodsid){
        //获得数据库对象
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $pay = $db->FetchOne('goods', array('goodsid'=>$goodsid), array('paytype', 'paynum'));
        return $pay;        
    } 
    
    
    /**
    * 描述: 免费获取
    * @date: 2016年5月17日 下午3:43:00
    * @author: xinbingliang <709464835@qq.com>
    * @param: $goodsname 货物名称
    * @return:
    */
    static function FreeGet($goodsname){
        //当前用户id
        $userid = $_SESSION['user']['userid'];
        //当前针对的商品的id
        $goodsid = $_SESSION['goods']['goodsid'];
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $data = $db->FetchAll('get', " userid = {$userid} and goodsid = {$goodsid} ");
        //只有当前用户不在获得表中才添加
        if (empty($data)) {
            //商品所有者id
            $goodsuserid = $_SESSION['goods']['userid'];
            //当前用户名
            $username = $_SESSION['user']['username'];
            //写get表
            $time = time();
            $db->Insert('get', array('userid'=>$userid, 'goodsid'=>$goodsid, 'time'=>$time));
            //通知物主
            $mess = "<a href='http://localhost/jie/index.php/User/Index&userid={$userid}'>{$username}</a>希望免费获得您的<a href='http://localhost/jie/index.php/Goods/Index&gid={$goodsid}'>{$goodsname}</a>";
            \App\Model\Lisa::SystemChat($goodsuserid, $mess);
            //want值加一
            $wantArr = $db->FetchOne('goods', array('goodsid'=>$goodsid), array('want')); 
            $wantnum = $wantArr['want']+1;
            $db->Update('goods', array('want'=>$wantnum), " goodsid = {$goodsid} ");
            echo "TRUE";
        } else {
            echo "FALSE";
        }
    }
    
    
    /**
    * 描述: 人民币支付获取
    * @date: 2016年5月17日 下午3:51:20
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
/*     static function RMBGet(){
        //当前用户id
        $userid = $_SESSION['user']['userid'];
        //当前针对的商品的id
        $goodsid = $_SESSION['goods']['goodsid'];
        //商品所有者id
        $goodsuserid = $_SESSION['goods']['userid'];
        
    } */
    
    
    /**
    * 描述: 积分支付获取
    * @date: 2016年5月17日 下午3:52:04
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
/*     static function PointGet(){
        //当前用户id
        $userid = $_SESSION['user']['userid'];
        //当前针对的商品的id
        $goodsid = $_SESSION['goods']['goodsid'];
        //商品所有者id
        $goodsuserid = $_SESSION['goods']['userid'];
        
    } */
    
}
?>
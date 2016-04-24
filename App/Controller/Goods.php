<?php
namespace App\Controller;
/**
* 文件描述: 商品详情页面
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月22日 下午4:35:21
* @version 1.0.0
* @copyright  CopyRight
*/
class Goods{
    function Index(){
        //获得注册器
        $register = \Xin\Register::Instance();
        $key = $register->GetValue('data');
        $goodsid = $key['gid'];
        $getgoods = new \App\Model\GoodsGet();
        //查询数据数量和位置
        $getgoods->GetGoodsTab(0 , 10, "goodsid = $goodsid", 'order by goodstime');
        //向商品数据中添加用户数据
        $getgoods->GetGoodUser();

        //获得商品信息数据容器        
        $goodsbox = $register->GetValue('goods');
        $goodsbox->rewind();
        
        //获得商品数据
        while ($goodsbox->TheValue()){
            //获得单个货物信息
            $oneGoods = $goodsbox->current();
            $goodsid = $oneGoods['goodsid'];
            $userid = $oneGoods['userid'];
            $goodsimg0 = $oneGoods['goodsimg0'];
            $goodsimg1 = $oneGoods['goodsimg1'];
            $goodsimg2 = $oneGoods['goodsimg2'];
            $goodsimg3 = $oneGoods['goodsimg3'];
            $goodsname = $oneGoods['goodsname'];
            $goodsdepict = $oneGoods['goodsdepict'];
            $paytype = $oneGoods['paytype'];
            $paynum = $oneGoods['paynum'];
            $goodstime = date('Y-m-d H:i:s' , $oneGoods['goodstime']);
            $commentnum = $oneGoods['commentnum'];
            $zannum = $oneGoods['zannum'];
            $want = $oneGoods['want'];
            $username = $oneGoods['username'];
            $userimg = INLET.'headimg/'.$oneGoods['userimg'];
            $gender = $oneGoods['gender'];
            $point = $oneGoods['point'];
            $day = $oneGoods['day'].'后下架';
           
            if($paytype == 0 || $paytype == 0){
                $pay = "免费";
            } else if($paytype == 1){
                $pay = $paytype.'元';
            } else {
                $pay = $paytype.'积分';
            }
            //将部分必要信息写入session中
            //发布者id
            $_SESSION['goods']['userid'] = $userid;
            //货物id
            $_SESSION['goods']['goodsid'] = $goodsid;
            
            $goodsbox->next();
        }
        
        //获得商品评论数据
        $data = \App\Model\GoodsHand::get(0);
/*         var_dump($data);
        exit();  */
        //显示
        include ROOT.'App/view/top.html';
        echo '<link href="http://localhost/jie/App/View/style/all.css" rel="stylesheet" type="text/css"/>';
        echo '<link href="http://localhost/jie/App/View/style/goods.css" rel="stylesheet" type="text/css"/>';
        include ROOT.'App/view/head.html'; 
        include ROOT.'App/view/goods.php';
        include ROOT.'App/view/footer.html';
        var_dump($_SESSION); 
    }
    
    /**
    * 描述: 评论ajax提交
    * @date: 2016年4月22日 下午4:35:51
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function PushDis(){
        //数据过滤
        $gdcontent = \App\Model\ClearString::IsNone($_POST['gdcontent']);
        if(empty($gdcontent)){
            echo "数据不能为空";
        }
        $gdcontent = \App\Model\ClearString::ReturnClear($gdcontent);
        //组装其他必要数据
        $goodsdiscuss = array();
        //内容
        $goodsdiscuss['gdcontent'] = $gdcontent;
        //商品id
        $goodsdiscuss['goodsid'] = $_SESSION['goods']['goodsid'];
        //商品发布者id
        $gooduserid = $_SESSION['goods']['userid'];
        //评论时间
        $goodsdiscuss['gdtime'] = time();
        
        //被回复的评论
        $goodsdiscuss['touserid'] = $_POST['touserid'];
/*         echo $goodsdiscuss['touserid'];
        exit(); */
        //回复所有者id
        $goodsdiscuss['userid'] = $_SESSION['user']['userid'];
        
        //写入数据库
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $db->Insert('goodsdiscuss', $goodsdiscuss);
        //评论通知物主
       echo "0";
    }
    
    
    /**
    * 描述: 评论向上翻页
    * @date: 2016年4月24日 下午1:48:02
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function Pre(){
        //获得商品评论数据
        if($_SESSION['goodpage'] > 0){
            --$_SESSION['goodpage'];
            $data = \App\Model\GoodsHand::get($_SESSION['goodpage']);
            echo json_encode($data);
        }else{
            echo json_encode(array('error', 'top'));
        } 
    }
    
    /**
    * 描述: 评论向下翻页
    * @date: 2016年4月24日 下午1:48:30
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function Nex(){
        //获得商品评论数据
        if($_SESSION['goodpage'] < $_SESSION['goodpageall']){
            ++$_SESSION['goodpage'];
            $data = \App\Model\GoodsHand::get($_SESSION['goodpage']);
            echo json_encode($data);
        }else{
            echo json_encode(array('error', 'last'));
        }
    }

}

?>
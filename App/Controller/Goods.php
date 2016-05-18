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
            $chatuserid = $userid;
            $goodsimg0 = $oneGoods['goodsimg0'];
            $goodsimg1 = $oneGoods['goodsimg1'];
            $goodsimg2 = $oneGoods['goodsimg2'];
            $goodsimg3 = $oneGoods['goodsimg3'];
            $goodsname = $oneGoods['goodsname'];
            $goodsdepict = $oneGoods['goodsdepict'];
            $paytype = $oneGoods['paytype'];
            $paynum = $oneGoods['paynum'];
            $goodstime = date('m-d H:i' , $oneGoods['goodstime']);
            $commentnum = $oneGoods['commentnum'];
            $zannum = $oneGoods['zannum'];
            $want = $oneGoods['want'];
            $goodsUsername = $oneGoods['username'];
            $userimg = INLET.'headimg/'.$oneGoods['userimg'];
            $goodsgender = $oneGoods['gender'];
            $point = $oneGoods['point'];
            $day = $oneGoods['day'].'天过期';

            /* 判断类型  */
            if($paynum == 0 || $paytype== 0){
                $pay = '<i class="demo-icon icon-gift">&#xe869;</i>';
            } else if($paytype == 1) {
                $pay =  $paynum.'<i class="demo-icon icon-yen">&#xe86c;</i>';
            } else {
                $pay = $paynum.'<i class="demo-icon icon-database">&#xe86f;</i>';
            }
            
/*             if($paytype == 0 || $paytype == 0){
                $pay = "免费";
            } else if($paytype == 1){
                $pay = $paytype.'元';
            } else {
                $pay = $paytype.'积分';
            } */
            //将部分必要信息写入session中
            //发布者id
            $_SESSION['goods']['userid'] = $userid;
            //货物id
            $_SESSION['goods']['goodsid'] = $goodsid;
            
            $goodsbox->next();
        }
        
        //获得商品评论数据
        $data = \App\Model\GoodsHand::get(0);
        //希望得到的用户列表
        $userList = \App\Model\GoodsHand::FirstUserList($goodsid);
        
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
        $goodsdiscuss['touserid'] = empty($_POST['touserid'])?0:$_POST['touserid'];
/*         echo $goodsdiscuss['touserid'];
        exit(); */
        //回复所有者id
        $goodsdiscuss['userid'] = $_SESSION['user']['userid'];
        
        //写入数据库
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $db->Insert('goodsdiscuss', $goodsdiscuss);
        $username = $_SESSION['user']['username'];
        //评论通知物主
        //获得当前页的链接
        /* $host = $_SERVER['HTTP_HOST'];
        $REQUEST_URI = $_SERVER['REQUEST_URI'];
        $url = $host.$REQUEST_URI;
        \App\Model\ClearString::ReturnClear($url);*/
        //商品表中记录被评论次数的更新
        $commentnum = $db->FetchOne('goods', array('goodsid'=>$goodsdiscuss['goodsid']), array('commentnum'));
        $commentnum = $commentnum['commentnum']+1;
        
        $db->Update('goods', array('commentnum'=>$commentnum), " goodsid = {$goodsdiscuss['goodsid']} ");
        
        $url = 'http://'.$_SERVER['SERVER_NAME'].'/jie/index.php/Goods/Index&gid='.$_SESSION['goods']['goodsid']; 
        $userid = $_SESSION['user']['userid'];
        //通知被回复者
        if($goodsdiscuss['touserid'] != $_SESSION['user']['userid']){
            if ($goodsdiscuss['touserid'] > 0) {
                $mess = $username.'回复您:'."<a href='$url'>$gdcontent</a>";
                \App\Model\Lisa::SystemChat($goodsdiscuss['touserid'], $mess);
            } else {
                $mess = $username."评论您:"."<a href='$url'>$gdcontent</a>";
                \App\Model\Lisa::SystemChat($gooduserid, $mess);
            }
        }
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
    
    
    /**
    * 描述: 用户点赞
    * @date: 2016年5月16日 下午4:58:57
    * @author: xinbingliang <709464835@qq.com>
    * @return:
    */
    function Zambia(){
        $userid = $_SESSION['user']['userid'];
        $goodsid = $_POST['goodsid'];
/*         file_put_contents(ROOT.'message.txt', $goodsid);
        exit(); */
        //检查数据库中是否已经存在该值
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $data = $db->FetchAll('zambia', " userid = {$userid} and goodsid = {$goodsid} ");
        if(empty($data)){
            //向赞表中写数据
            $time = time();
            $db->Insert('zambia', array('userid'=>$userid, 'goodsid'=>$goodsid, 'time'=>$time));
            //获得商品赞数目加一
            $zannum = $db->FetchOne('goods', array('goodsid'=>$goodsid), array('zannum', 'userid', 'goodsname'));
            $touserid = $zannum['userid'];
            $goodsname = $zannum['goodsname'];
            /* userid */
            $zannum = $zannum['zannum']+1;
            //回写
            $db->Update('goods', array('zannum'=>$zannum), " goodsid = {$goodsid} ");
            //当前用户不是商品所有者就向用户做通知
            if($touserid != $_SESSION['user']['userid']){
                //获得评论者的用户名
                $username = $_SESSION['user']['username'];
                //组装消息
                $mess = "{$username}赞了您的\"{$goodsname}\"";
                \App\Model\Lisa::SystemChat($touserid, $mess);
            }
            //返回标识位
             echo "ZambiaTrue"; 
        } else {
            //直接返回标识位
            echo "ZambiaFalse";
        }
    }
    
    /**
    * 描述: 获得商品
    * @date: 2016年5月17日 下午2:37:19
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function Want(){
        //货物名称
        $goodsname = $_POST['goodsname'];
        //当前用户id
        $userid = $_SESSION['user']['userid'];
        //当前针对的商品的id
        $goodsid = $_SESSION['goods']['goodsid'];
        //商品所有者id
        $goodsuserid = $_SESSION['goods']['userid'];
        //获得商品的支付方式
        $pay = \App\Model\WantGoods::GetPayType($goodsid);
        
        //获得支付的方式
        /* if ($pay['paytype'] == 0 || $pay['paynum'] == '0') {
            //免费送
            \App\Model\WantGoods::FreeGet($goodsname);
        } else if ($pay['paytype'] == 1) {
            //人民币支付
            
            
        } else if ($pay['paytype'] == 2) {
            //积分购买
            
        } */
        \App\Model\WantGoods::FreeGet($goodsname);
        
        
    }
    
    
    /**
    * 描述: 想要用户向上发翻页
    * @date: 2016年5月18日 上午12:32:02
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function UserListpre(){
        $page = $_SESSION['goods']['userlist']['page']-1;
        if($page >= 0){
            $data = \App\Model\GoodsHand::UserList($page*20);
            echo json_encode($data);
            $_SESSION['goods']['userlist']['page'] = $_SESSION['goods']['userlist']['page']-1;
        }
    }

    /**
    * 描述: 想要用户向下发翻页
    * @date: 2016年5月18日 上午12:32:31
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function UserListnex(){
        $page = $_SESSION['goods']['userlist']['page']+1;
        $allnum = ceil($_SESSION['goods']['userlist']['allnum']/20)*20;
        $num = $page*20;
        if($num < $allnum){
            $data = \App\Model\GoodsHand::UserList($num);
            echo json_encode($data);
            $_SESSION['goods']['userlist']['page'] = $_SESSION['goods']['userlist']['page']+1;
        }
        
    }
    
    /**
    * 描述: 物主选择赠予对象
    * @date: 2016年5月18日 下午3:23:14
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function Chico(){
        $userid = $_POST['userid'];
        $goodsname = $_POST['goodsname'];

        
        //获得商品的支付方式
        $goodsid = $_SESSION['goods']['goodsid'];
        $pay = \App\Model\WantGoods::GetPayType($goodsid);
        if ($pay['paytype'] == 0 || $pay['paynum'] == '0') {
            //免费送
            echo "已经通知该用户,同时本产品已经下线！";
        } else if ($pay['paytype'] == 1) {
            //人民币支付
            echo "已经通知该用户,同时本产品已经下线。支付和交货事宜请协商完成！";
        } else if ($pay['paytype'] == 2) {
            //积分购买
            //积分转账
            $flag = \App\Model\GoodsHand::PointChange($pay['paynum'], $_SESSION['user']['userid'], $userid);
            if(empty($flag)){
                echo "已经通知该用户,同时本产品已经下线。积分已经自动转入您的账户！";
                //终止程序执行
            } else {
                echo $flag.',请重新选择!';
                return;
            }
           
        }
        //彼此添加到交流表中
        \App\Model\GoodsHand::AddFirst($userid, $_SESSION['user']['userid']);
        \App\Model\GoodsHand::AddFirst( $_SESSION['user']['userid'], $userid);
        //将产品过期
        \App\Model\GoodsHand::GoodsOut();
        //通知该该用户
        $mess = $goodsname."的物主已经同意给您，已经将该物主添加到您的联系表中，交货事宜请及时与其沟通。";
        \App\Model\Lisa::SystemChat($userid, $mess);
        
    }
    
    
}

?>
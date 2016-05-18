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
    
    /**
    * 描述: 进入页面时获得希望获得用户列表
    * @date: 2016年5月18日 上午12:20:58
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    static function FirstUserList($goodsid){
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        //设置起始页
        $_SESSION['goods']['userlist']['page'] = 0;
        //设置总数目
        $allnum = $_SESSION['goods']['userlist']['allnum'] = $db->FetchNum("select * from j_get where goodsid = {$goodsid}");
        $_SESSION['goods']['userlist']['allnum'] = $allnum;
        //调用获得
        return self::UserList(0);
        //返回数据
        
    }

    /**
     * 描述: 获得希望获得商品的用户名id和头像
     * @date: 2016年5月17日 下午5:53:20
     * @author: xinbingliang <709464835@qq.com>
     * @param: $goodsid 商品的id
     * @return:
     */
    static function UserList($start){
        $goodsid = $_SESSION['goods']['goodsid'];
        //获得数据库对象
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        //获得相关用户id并按时间先后顺序排序
        $userList = $db->FetchAll('get', " goodsid = {$goodsid} ", NULL, " limit {$start}, 20 ", 'order by time desc');
        //循环根据用户id获得用户名和头像
        if(!empty($userList)){
            foreach ($userList as &$value){
                $data = $db->FetchOne('user', array('userid'=>$value['userid']), array('username', 'userimg'));
                $value[] = $data;
            }
        }
        return $userList;
    }
    
    
    /**
    * 描述: 将用户添加到最开始位置
    * @date: 2016年5月18日 下午3:40:02
    * @author: xinbingliang <709464835@qq.com>
    * @param: $userid 主
    * @param: $touserid 被添加的 
    * @return:
    */
    function AddFirst($userid, $touserid){
        //获得数据库对象
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $data = $db->FetchOne('user', array('userid'=>$userid), array('chatlist'));
        $chatlist = $data['chatlist'];
        $arr = explode(',', $chatlist);
        array_unshift($arr, $touserid);
        $arr = array_unique($arr);
        $str = join(',', $arr);
        trim($str, ',');
        //回写数据
        $db->Update('user', array('chatlist'=>$str), " userid = {$userid} ");
    }
    
    
    /**
    * 描述: 产品过期
    * @date: 2016年5月18日 下午3:47:11
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function GoodsOut(){
        $goodsid = $_SESSION['goods']['goodsid'];
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $db->Update('goods', array('goodsout'=>1), " goodsid = {$goodsid} ");
    }
    
    
    /**
    * 描述: 积分转账完成 
    * @date: 2016年5月18日 下午6:42:50
    * @author: xinbingliang <709464835@qq.com>
    * @param: $point 转的积分数量
    * @param: $touserid 被转入账户
    * @param: $userid 转出账户
    * @return:
    */
    function PointChange($point, $touserid, $userid){
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $data = $db->FetchOne('user', array('userid'=>$userid), array('point'));
        $startpoint = $data['point'];
        if($startpoint < $point){
            return  "对方积分不足";
        } else {
            try {
                $data = $db->FetchOne('user', array('userid'=>$touserid), array('point'));
                $endpoint = $data['point']+$point;
                $db->Update('user', array('point'=>$endpoint), " userid = $touserid ");
            } catch (\Exception $e){
                return "积分转账失败";
            }
        }
    }
    
}
?>
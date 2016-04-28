<?php
namespace App\Model;
/**
* 文件描述: 用户信息操作助手类
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月26日 下午10:00:35
* @version 1.0.0
* @copyright  CopyRight
*/

class UserHelp{
    //用户id
    private $userid;
    //存放数据
    private $data;
    
    /**
    * 描述: 获得注册器中要读取用户的信息
    * @date: 2016年4月26日 下午9:57:26
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function __construct(){
        //获得注册器对象
        $register = \Xin\Register::Instance(); 
        $data = $register->GetValue('data');
        $this->userid = $data['userid']; 
        $_SESSION['touserid'] = $this->userid;
        //判断是完整信息还是部分信息
    }
    
    /* 
     * 问题对数据商品信息的读取会在多个地方都会使用到，
     * 应该切分成更小的数据类
     *  
     *  */
    
    /**
    * 描述: 获取用户完整信息
    * @date: 2016年4月26日 下午10:26:44
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function Intact(){
        //获得数据库对象
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        //组装要查询的字段
        $queryArray = array('userid', 'username', 'time', 'birthday', 'userimg', 'gender', 'email', 'qq', 'address', 'tel', 'point');
        $this->data = $db->FetchOne('user', array('userid'=>$this->userid), $queryArray);
    }
    

    /**
    * 描述: 获取用户部分信息
    * @date: 2016年4月26日 下午10:29:35
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function Part(){
        
    }
    
    
    /**
    * 描述: 统一返回数据信息
    * @date: 2016年4月27日 上午9:08:10
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return: 返回用户信息数据
    */
    function ReturnUserMessage(){
        return $this->data;
    }
    
    
    /**
    * 描述:   获得用户评论数据
    * @date: 2016年4月28日 上午9:19:10
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function GetUserDis(){
        //获得数据库对象
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $data = $db->FetchAll('userdiscuss', " touserid = {$this->userid} ", NULL, NULL, ' order by udtime desc ');
        //获得评论数据的数量
        $num = count($data);
        $_SESSION['userdisnum'] = $num;
        $_SESSION['userdispage'] = 0;
        if(!empty($data)){
            $i = 0;
             foreach ($data as &$value){
                $res = $db->FetchOne('user', array('userid'=>$value['beuserid']), array('username', 'userimg'));
                $value['username'] = $res['username'];
                $value['userimg'] = $res['userimg'];
                $value['udtime'] = date('m-d H:i', $value['udtime']);
                $i ++;
                if($i == 9){
                    break;
                }
            } 
            return array_slice($data, 0, 9);
        }else {
            return null;
        }
    }
    
    
    /**
    * 描述: 获得用户自己的商品
    * @date: 2016年4月28日 上午11:26:15
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function GetGoods(){
        //获得数据库对象
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $data = $db->FetchAll('goods', " userid = {$this->userid} ", NULL, NULL, ' order by goodstime desc ');
        $_SESSION['goodpage'] = 0;
        $_SESSION['goodpageall'] = count($data);
        if(!empty($data)){
            foreach ($data as &$value){
                $res = $db->FetchOne('user', array('userid'=>$value['userid']), array('username', 'userimg'));
                $value['username'] = $res['username'];
                $value['userimg'] = $res['userimg'];
                $value['udtime'] = date('m-d H:i', $value['goodstime']);
            }
            return array_slice($data, 0, 6);
            /* return $data; */
        }else {
            return null;
        }
    }
    
    
    /**
    * 描述: 评论异步加载助手
    * @date: 2016年4月28日 下午3:49:35
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
   static function DisHelp($start){
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $data = $db->FetchAll('userdiscuss', " touserid = {$_SESSION['touserid']} ", NULL, " limit {$start}, 10 ", ' order by udtime desc ');
        if(!empty($data)){
            foreach ($data as &$value){
                $str = '';
                for($i=0; $i<$value['start']; $i++){
                    $str .= '<i class="demo-icon icon-star">&#xe811;</i>';
                }
                $value['start'] = $str;
                $res = $db->FetchOne('user', array('userid'=>$value['beuserid']), array('username', 'userimg'));
                $value['username'] = $res['username'];
                $value['userimg'] = $res['userimg'];
                $value['udtime'] = date('m-d H:i', $value['udtime']);
            }
            return $data;
        }else{
            return NULL;
        }
    }
    
    
    /**
    * 描述: 商品信息的异步加载
    * @date: 2016年4月28日 下午7:13:14
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    static function GoodsHelp($start){
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $data = $db->FetchAll('goods', " userid = {$_SESSION['touserid']} ", NULL, " limit {$start}, 6 ", ' order by goodstime desc ');
        if(!empty($data)){
            return $data;                
        }else{
            return null;
        }
    } 
    
}

?>
<?php
namespace App\Model;
/**
* 文件描述: 获取商品相关信息
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月21日 下午6:44:25
* @version 1.0.0
* @copyright  CopyRight
*/
class GoodsGet{
    /**
    * 描述: 获取商品表中的数据
    * @date: 2016年4月21日 下午6:51:41
    * @author: xinbingliang <709464835@qq.com>
    * @param: $$linenumber 其实行号
    * @param: $number 获得的数量
    * @param: variable
    * @return:
    */
    function GetGoodsTab($linenumber, $number, $where, $orderBy){
        //获得数据对象
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $limit = 'limit '.$linenumber.','.$number;
        /* 
         * 
         *  没有任何数据后,这里会有错，请后期排除此bug
         *  
         *  
         *  */
        //过期要进行时间判断，
        $timeflag = time()-(3600*24*15);
        //组装条件
        $where = empty($where)?"goodstime > {$timeflag}":$where. " and goodstime > {$timeflag}";
        
        //进行查询
        $data = $db->FetchAll('goods', $where, null, $limit, $orderBy);
/*         var_dump($data);
        exit(); */
        if(!empty($data)){
            //将数据存放到迭代器中
            $goodsIter = new GoodsBox($data);
            
            //将迭代器注册带注册器上
            $register->SetValue('goods', $goodsIter);
            return 'success';
        }else{
            return null;
        }

        
/*         $message = $register->GetValue('goods');
        var_dump($message->current()); */
    }
    
    /**
    * 描述: 根据商品信息中的用户ID获得用户信息， 并存放到商品容器中
    * @date: 2016年4月21日 下午7:42:09
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function GetGoodUser(){
        //获得货物信息容器
        $register = \Xin\Register::Instance();
        $goods = $register->GetValue('goods');
/*           var_dump($goods); 
         exit();  */
        if(!empty($goods)){
            //循环获取商品信息
            while($goods->TheValue()){
                $goodMessage = $goods->current();
                //获得用户id
                $userid = $goodMessage['userid'];
                //获得发布时间
                $pushTim = $goodMessage['goodstime'];
                $day = ceil((time()-$pushTim)/(3600*24));
                //获得数据库对象
                $db = $register->GetValue('db');
                $userarray = $db->FetchAll('user', "userid = $userid", $array = array('username', 'userimg', 'username', 'gender', 'point'));
                //将用户信息添加到容器中
                $key = $goods->key();
                $goods->AddUser($key, 'username', $userarray[0]['username']);
                $goods->AddUser($key, 'userimg', $userarray[0]['userimg']);
                $goods->AddUser($key, 'username', $userarray[0]['username']);
                $goods->AddUser($key, 'gender', $userarray[0]['gender']);
                $goods->AddUser($key, 'point', $userarray[0]['point']);
                $goods->AddUser($key, 'day', $day);
                $goods->next();
            }
            $goods->rewind();
        }
        
/*           var_dump($goods); 
         exit();  */
        //将迭代器指针指向第一个元素

    }
    
}

?>
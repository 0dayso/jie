<?php
namespace App\Controller;
/**
* 文件描述: 商品展示控制器
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月22日 上午10:21:17
* @version 1.0.0
* @copyright  CopyRight
*/
class ShowGoods{
    /**
    * 描述: 展示所有的商品
    * @date: 2016年4月22日 上午10:22:23
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @param: variable
    * @param: variable
    * @return:
    */
    function Index(){
        //组装数据
        $getgoods = new \App\Model\GoodsGet();
        //查询数据数量和位置
        $getgoods->GetGoodsTab(0 , 16, null, 'order by goodstime');
        //向商品数据中添加用户数据
        $getgoods->GetGoodUser();
        
        //获得商品信息容器
        $register = \Xin\Register::Instance();
        $goodsbox = $register->GetValue('goods');
        
        include ROOT.'App/view/index.php';
    }
    
    
    /**
     * 描述: 免费商品展示
     * @date: 2016年4月21日 下午9:59:05
     * @author: xinbingliang <709464835@qq.com>
     * @param: variable
     * @return:
     */
    function GetFree(){
        //组装数据
        $getgoods = new \App\Model\GoodsGet();
        $getgoods->GetGoodsTab(0 , 1000, 'paynum = 0', 'order by goodstime');
        //向商品数据中添加用户数据
        $getgoods->GetGoodUser();
    
        //获得商品信息容器
        $register = \Xin\Register::Instance();
        $goodsbox = $register->GetValue('goods');
    
        include ROOT.'App/view/index.php';
    }
    
    
    /**
    * 描述: 付费商品展示
    * @date: 2016年4月22日 上午10:26:02
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function GetPay(){
        //组装数据
        $getgoods = new \App\Model\GoodsGet();
        $getgoods->GetGoodsTab(0 , 1000, 'paynum > 0', 'order by goodstime');
        //向商品数据中添加用户数据
        $getgoods->GetGoodUser();
        
        //获得商品信息容器
        $register = \Xin\Register::Instance();
        $goodsbox = $register->GetValue('goods');
        
        include ROOT.'App/view/index.php';
    }
    
    
    /**
    * 描述: 加载更多的Ajax请求
    * @date: 2016年4月22日 上午10:28:24
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function GetMore(){
        
    }
    
    
}

?>
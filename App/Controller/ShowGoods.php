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
        //获得注册器
        $register = \Xin\Register::Instance();
        //如果原来异步加载对象把异步加载对象清除
        \App\Model\GoodsAjax::UnsetSelf();
        //请求并赋予新的请求类型
        $ajax = \App\Model\GoodsAjax::GetSelf();
        $ajax->SetAction('all');
        $register->SetValue('goodsajax', $ajax);
        //组装数据
        $getgoods = new \App\Model\GoodsGet();
        //查询数据数量和位置
        $getgoods->GetGoodsTab(0 , 15, null, 'order by goodstime');
        //向商品数据中添加用户数据
        $getgoods->GetGoodUser();
        
        //获得商品信息容器

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
        //获得注册器
        $register = \Xin\Register::Instance();
        //如果原来异步加载对象把异步加载对象清除
        \App\Model\GoodsAjax::UnsetSelf();
        //请求并赋予新的请求类型
        $ajax = \App\Model\GoodsAjax::GetSelf();
        $ajax->SetAction('free');
        $register->SetValue('goodsajax', $ajax);
        //组装数据
        $getgoods = new \App\Model\GoodsGet();
        $getgoods->GetGoodsTab(0 , 15, 'paynum = 0', 'order by goodstime');
        //向商品数据中添加用户数据
        $getgoods->GetGoodUser();
        //获得商品信息容器
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
        //获得注册器
        $register = \Xin\Register::Instance();
        //如果原来异步加载对象把异步加载对象清除
        \App\Model\GoodsAjax::UnsetSelf();
        //请求并赋予新的请求类型
        $ajax = \App\Model\GoodsAjax::GetSelf();
        $ajax->SetAction('pay');
        $register->SetValue('goodsajax', $ajax);
        //组装数据
        $getgoods = new \App\Model\GoodsGet();
        $getgoods->GetGoodsTab(0 , 15, 'paynum > 0', 'order by goodstime');
        //向商品数据中添加用户数据
        $getgoods->GetGoodUser();
        
        //获得商品信息容器
        $goodsbox = $register->GetValue('goods');
        
        include ROOT.'App/view/index.php';
    }
    
    
    /**
    * 描述: 使用GoodsAjax类加载内容
    * @date: 2016年4月22日 上午10:28:24
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function GetMore(){
        //获得注册器
        $register = \Xin\Register::Instance();
        $ajax = $register->GetValue('goodsajax');
        
        $data = $ajax->GetMore();

        
        if(!empty($data)){
            //获得商品信息容器
            $register = \Xin\Register::Instance();
            $goodsbox = $register->GetValue('goods');
            var_dump($goodsbox);
        }
    }
}

?>
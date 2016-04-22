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
        //页面展示
        include ROOT.'App/view/head.html';
        include ROOT.'App/view/goods.html';
        include ROOT.'App/view/footer.html';
    }
    
    /**
    * 描述: 加载页面
    * @date: 2016年4月22日 下午4:35:51
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function GetPage(){
        
    }
}

?>
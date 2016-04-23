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
class Show{
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
        //本次请求类型写入session
        $_SESSION['getgoods'] = NULL;
        $_SESSION['getgoods']['type'] = 'all';
        $_SESSION['getgoods']['num'] = 1;
        //组装数据
        $getgoods = new \App\Model\GoodsGet();
        //查询数据数量和位置
        $getgoods->GetGoodsTab(0 , 1, null, 'order by goodstime');
        //向商品数据中添加用户数据
        $getgoods->GetGoodUser();
        //获得商品信息容器
        include ROOT.'App/view/top.html';
        echo '<link href="http://localhost/jie/App/View/style/index.css" rel="stylesheet" type="text/css"/>';
        include ROOT.'App/view/head.html';
        $goodsbox = $register->GetValue('goods');
        include ROOT.'App/view/index.php';
        include ROOT.'App/view/footer.html';
    }
    
    
    /**
     * 描述: 免费商品展示
     * @date: 2016年4月21日 下午9:59:05
     * @author: xinbingliang <709464835@qq.com>
     * @param: variable
     * @return:
     */
    function Free(){
        //获得注册器
        $register = \Xin\Register::Instance();
        $_SESSION['getgoods'] = NULL;
        //本次请求类型写入session
        $_SESSION['getgoods']['type'] = 'free';
        $_SESSION['getgoods']['num'] = 1;

        //组装数据
        $getgoods = new \App\Model\GoodsGet();
        $getgoods->GetGoodsTab(0 , 1, 'paynum = 0', 'order by goodstime');
        //向商品数据中添加用户数据
        $getgoods->GetGoodUser();
        //获得商品信息容器
        include ROOT.'App/view/top.html';
        echo '<link href="http://localhost/jie/App/View/style/index.css" rel="stylesheet" type="text/css"/>';
        include ROOT.'App/view/head.html';
        $goodsbox = $register->GetValue('goods');
        include ROOT.'App/view/index.php';
        include ROOT.'App/view/footer.html';
    }
    
    
    /**
    * 描述: 付费商品展示
    * @date: 2016年4月22日 上午10:26:02
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function Pay(){
        //获得注册器
        $register = \Xin\Register::Instance();
        $_SESSION['getgoods'] = NULL;
        //本次请求类型写入session
        $_SESSION['getgoods']['type'] = 'pay';
        $_SESSION['getgoods']['num'] = 1;
        //组装数据
        $getgoods = new \App\Model\GoodsGet();
        $getgoods->GetGoodsTab(0 , 1, 'paynum > 0', 'order by goodstime');
        //向商品数据中添加用户数据
        $getgoods->GetGoodUser();
        //获得商品信息容器
        include ROOT.'App/view/top.html';
        echo '<link href="http://localhost/jie/App/View/style/index.css" rel="stylesheet" type="text/css"/>';
        include ROOT.'App/view/head.html';
        $goodsbox = $register->GetValue('goods');
        include ROOT.'App/view/index.php';
        include ROOT.'App/view/footer.html';
    }
    
    
    /**
    * 描述: 使用Gjax类加载内容
    * @date: 2016年4月22日 上午10:28:24
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function More(){
        //请求ajax方法
        $ajax = \App\Model\Gjax::GetSelf();
        $data = $ajax->GetMore();
        if(!empty($data)){
            $_SESSION['getgoods']['num'] += 3;
            echo $data;
        } else {
            echo null;
        }
    }
    
}

?>
<?php
namespace App\Model;
/**
* 文件描述: 商品异步加载，处理，可能要保存操作环境，所以这里使用单例
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月22日 上午11:26:14
* @version 1.0.0
* @copyright  CopyRight
*/
final class GoodsAjax{
    //保存自身
    private static $Instance = NULL;
    //记录免费，全部，还是付费不同的类型
    static private $action;
    //记录起始位置
    static private $num = 15;
    
     
    private function __construct(){
        //默认是全部
        self::$action = 'all';
    }
    
    //获得对象自身
    static function GetSelf(){
        if(self::$Instance == NULL){
            self::$Instance = new self();
        }
        return self::$Instance;
    }
    
    
    //重置动作方式
    function SetAction($type){
        self::$action = $type;
    }
    
    /**
    * 描述: 加载商品
    * @date: 2016年4月22日 下午12:44:34
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function GetMore(){
        $where = '';
        switch (self::$action){
            case 'all':
                $where = NULL;
                break;
            case 'free':
                $where = 'paynum = 0';
                break;
            case 'pay':
                $where = 'paynum > 0';
                break;
            default:
                $where = null;
                break;
        }
        
        echo self::$action;
        exit();
        //组装数据
        $getgoods = new \App\Model\GoodsGet();
        //返回数据标识
        $message = $getgoods->GetGoodsTab(self::$num , 15, $where, 'order by goodstime');
        if(!empty($message)){
            //向商品数据中添加用户数据
            $getgoods->GetGoodUser();
            //获得商品信息容器
            $register = \Xin\Register::Instance();
            $goodsbox = $register->GetValue('goods');
            //拼装成json返回
            return 'success';
        }else{
            return NULL;
        }
        self::$num += 15;
    }
    
    //销毁自身
    static function UnsetSelf(){
        self::$Instance = NULL;
    }
}

?>
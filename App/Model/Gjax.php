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
final class Gjax{
    //保存自身
    private static $Instance = NULL;
     
    private function __construct(){
    }
    
    //获得对象自身
    static function GetSelf(){
        if(self::$Instance == NULL){
            self::$Instance = new self();
        }
        return self::$Instance;
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
        //获得注册器
        $type = $_SESSION['getgoods']['type'];
        $num = $_SESSION['getgoods']['num'];
/*         file_put_contents(ROOT.'message.txt', $type);
        exit(); */
        switch ($type){
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
        //组装数据
        $getgoods = new \App\Model\GoodsGet();
        //返回数据标识
        $register = \Xin\Register::Instance();
        $register->SetValue('goods', NULL);
        $message = $getgoods->GetGoodsTab( $num, 3, $where, 'order by goodstime desc');
        if(!empty($message)){
            //向商品数据中添加用户数据
            $getgoods->GetGoodUser();
            //获得商品信息容器
            $goodsbox = $register->GetValue('goods');
            //获得所有数据
            $data = $goodsbox->GetAll();
            //拼装成json返回
            $data = json_encode($data);
            return $data;
            
        }else{
            return NULL;
        }
    }
}

?>
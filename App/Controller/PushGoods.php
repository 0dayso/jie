<?php
namespace App\Controller;
/**
* 文件描述: 商品上传模块，必须做字符检测
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月17日 下午10:23:25
* @version 1.0.0
* @copyright  CopyRight
*/
class PushGoods{
    //检测是否已经登录
    function Index(){
        include ROOT.'App/view/index.php';
    }
    
    
    /**
    * 描述: 商品名称上传入口，存储到session中
    * @date: 2016年4月19日 下午7:08:15
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function PushName(){
        $goodsname = \App\Model\ClearString::IsNone($_POST['goodsname']);
        if($goodsname != NULL){
            //不为空,做过滤并写入session,
            $goodsname = \App\Model\ClearString::ReturnClear($goodsname);
            $_SESSION['goods']['goodsname'] = $goodsname;
            echo $_SESSION['goods']['goodsname'];
        }else{
            //为空返回通知，并清空session['goods']['goodsname']
            echo "名称不能为空";
            $_SESSION['goods']['goodsname'] = null; 
        }
    }
    
    
    /**
    * 描述: 描述上传入口，成功后存储到session中
    * @date: 2016年4月19日 下午7:09:04
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function PushgDepict(){
        $goodsdepict = \App\Model\ClearString::IsNone($_POST['goodsdepict']);
        if(strlen($goodsdepict) < 12 || $goodsdepict == NULL){
            echo "描述太少了";
            //清空掉描述
            $_SESSION['goods']['goodsdepict'] = NULL;
        }else{
            //做过滤并存储到session中
            $goodsdepict = \App\Model\ClearString::ReturnClear($goodsdepict);
            $_SESSION['goods']['goodsdepict'] = $goodsdepict;
            echo $_SESSION['goods']['goodsdepict'];
        }
    }
    
    
    /**
    * 描述: 售卖类型和价格
    * @date: 2016年4月19日 下午7:09:41
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function PayNum(){
        //非空和正则数据判断
        $num = \App\Model\ClearString::IsNone($_POST['paynum']);
        if(preg_match('/^[0-9]{1,5}(.[0-9]{1,3})?$/', $num)){
            $paytype = $_POST['paytype'];
            if($paytype==2 && preg_match('/^[0-9]{1,5}$/', $num)){
                $_SESSION['goods']['paytype'] = $paytype;
                //过滤数据存放到session中
                $_SESSION['goods']['paynum'] = $num;
/*                 echo $_SESSION['goods']['paytype']; */
            }else if($paytype==1){
                $_SESSION['goods']['paytype'] = $paytype;
                //过滤数据存放到session中
                $_SESSION['goods']['paynum'] = $num;
/*                 echo $_SESSION['goods']['paytype']; */
            }else{
                echo "数据格式不对";
            }
        }else{
            //格式不对要清除原来的数据
            $_SESSION['goods']['paynum'] = null;
            echo "金额格式不对";
        }   
    }
    
    /**
    * 描述:  图片上传操作，必须其他所有数据都上传完成后，才能进行
    * @date: 2016年4月19日 下午7:24:47
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function SubmitFile(){
        //图片上传,并进行缩放转存
        $obj = new \App\Model\GoodsHelp();
        $return = $obj->ImageUp();
        //检查所有数据是否存在,图片第一张必须存在
        $goodsarray = array('goodsname', 'goodsimg0', 'goodsdepict'); 
        foreach ($goodsarray as $value){
            $res = $obj->CheckEmpty($value);
            echo $res;
            if($res != null){
                echo "数据没有设置完整";
                return NULL;
            }
         } 
         if($obj->WriteDB() == NULL){
            $this->Index();  
            $_SESSION['goods'] = NULL;
        }
    }
    
    //检查需要支付的金额,并计算要支付的金额
    
    
    //已经将其他数据存储到里session中，这里是图片上传，若在其中没有类型和价格默认为0
    
}
?>
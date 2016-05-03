<?php
namespace App\Model;
/**
* 文件描述: 商品最终上传操作，和相应图片处理
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月19日 下午7:26:48
* @version 1.0.0
* @copyright  CopyRight
*/
class GoodsHelp{ 
    /**
    * 描述: 图片上传，缩放和转存
    * @date: 2016年4月20日 下午5:58:36
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function ImageUp(){
        //判断用户是否已经登录
        if(!empty($_SESSION['user']['userid'])){
            if(!empty($_FILES)){
                $upObj = new \Xin\FileUp();
                if($upObj->Upload('file')){
                    //获得图片数组，并将数组存放到session中
                    $imageNames = $upObj->GetFileName();
                    for($i=0; $i<count($imageNames); $i++){
                        $name = 'goodsimg'.$i;
                        $_SESSION['goods'][$name] = $imageNames[$i];
                    }
                    //调用方法，进行图像的缩放
                    foreach ($imageNames as $value){
                        //缩放图片,并销毁临时图片
                        \Xin\ImageHandle::Tumb(400, 400, ROOT.'tmp/'.$value, ROOT.'goodsimg/');
                    }
                    return NULL;
                    return '图片上传成功!';
                }else {
                    return '图片上传失败';
                }
            }else{
                return "没有选择文件";
            }
        }else{
             return "你还没有登录";
        }
    }
    
    
    /**
    * 描述:  检查所有内容是否已经上传
    * @date: 2016年4月20日 下午6:00:30
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    public function CheckEmpty($type){
        if(isset($_SESSION['goods'][$type])){
            $_SESSION['goods'][$type] = trim($_SESSION['goods'][$type]);
        }else{
            return $type.'未设置';
        }
        if(empty($_SESSION['goods'][$type])){
            return $type."为空";
        }
        return NULL;
    }
    
    
    /**
    * 描述: 将信息写入数据库
    * @date: 2016年4月20日 下午6:14:11
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function WriteDB(){
        //获得用户ID
        $_SESSION['goods']['userid'] = $_SESSION['user']['userid'];
        $_SESSION['goods']['goodstime'] = time();
        
        //存放到数据库中
         $register = \Xin\Register::Instance();
         $db = $register->GetValue('db');
         $db->Insert('goods', $_SESSION['goods']);
         return NULL;
        
    }
    
}

?>
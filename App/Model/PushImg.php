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
class PushImg{ 
    //图片上传操作
    function ImageUp(){
        //判断用户是否已经登录
        if(!empty($_SESSION['user']['userid'])){
            //判断是否有上传内容，优化时使用前端进行监听
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
    
}

?>
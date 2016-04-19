<?php
namespace Xin;
/**
* 文件描述: 文件上传类
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月19日 下午7:29:43
* @version 1.0.0
* @copyright  CopyRight
*/
class FileUp{
    private $path = ROOT.'tmp';                                 //上传文件保存的位置
    private $allowType = array('jpg', 'jpeg', 'png', 'gif');    //允许上传的文件类型
    private $maxSize = 2000000;                                 //文件最大允许的大小
    private $isRandname = true;                                 //是否设置重命名
    
    private $originName;                                        //源文件名
    private $tmpFileName;                                       //临时文件名
    private $fileType;                                          //文件类型(后缀)
    private $fileSize;                                          //文件大小
    private $newFileName;                                       //新文件名
    private $errorNum = 0;                                      //错误号
    private $errorMessage = "";                                 //错误报告消息
    
    /**
    * 描述: 调用来设置属性
    * @date: 2016年4月19日 下午7:48:44
    * @author: xinbingliang <709464835@qq.com>
    * @param: $key 属性名称
    * @param: $val 属性值
    * @return:
    */
    function Set($key, $val){
        
    }
    
    
    /**
    * 描述: 上传方法,成功返回TRUE
    * @date: 2016年4月19日 下午7:51:11
    * @author: xinbingliang <709464835@qq.com>
    * @param: $fileField 上传的文件名称
    * @return:
    */
    function Upload($fileField){
        
    }
    
    /**
    * 描述: 获得文件上传后新的文件名称
    * @date: 2016年4月19日 下午7:53:11
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return: 返回文件上传后的名称
    */
    function GetFileName(){
        
    }
    
    
    /**
    * 描述: 返回上传失败后的信息
    * @date: 2016年4月19日 下午7:54:28
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return: 返回上传失败后的信息
    */
    function GetErrorMsg(){
        
    }
    
    /**
    * 描述: 设置上传出错信息
    * @date: 2016年4月19日 下午7:55:29
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return: 返回错误信息
    */    
    private function GetError(){
        
    } 
    
    
    /**
    * 描述: 设置和$_FILES相关的信息
    * @date: 2016年4月19日 下午7:56:28
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    private function SetFiles($name="", $tmp_name="", $size=0, $error=0){
        
    }
    
    
    /**
    * 描述: 为单个属性设置值
    * @date: 2016年4月19日 下午7:58:02
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    private function SetOption($key, $val){
        
    }
    
    
    /**
    * 描述: 设置上传后的文件名称
    * @date: 2016年4月19日 下午7:59:06
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    private function setNewFileName(){

    }
    
    /**
    * 描述: 检测
    * @date: 2016年4月19日 下午8:00:14
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    
}

?>
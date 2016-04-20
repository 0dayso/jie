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
    private $path = './tmp';                                 //上传文件保存的位置
    private $allowType = array('jpg', 'jpeg', 'png', 'gif');    //允许上传的文件类型
    private $maxSize = 2000000;                                 //文件最大允许的大小
    private $isRandname = true;                                 //是否设置重命名
    
    private $num = 0;                                           //是第几张图片
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
        $key = strtolower($key);
        if(array_key_exists($key, get_class_vars(get_class($this)))){
            $this->SetOption($key, $val);
        }
        //可以链式操作
        return $this;
    }
    
    
    /**
    * 描述: 上传方法,成功返回TRUE
    * @date: 2016年4月19日 下午7:51:11
    * @author: xinbingliang <709464835@qq.com>
    * @param: $fileField 上传的文件名称
    * @return:
    */
    function Upload($fileField){
        $this->ClearEmpty($fileField);
        $return = TRUE;                                         //返回标记位
        //检查上传到的位置是否合法
        if(!$this->CheckFilePath()){
            $this->errorMessage = $this->GetError();
            return FALSE;
        }
        
        //提取上传文件的信息，保存到变量中
        $name = $_FILES[$fileField]['name'];                    //文件名称
        $tmp_name = $_FILES[$fileField]['tmp_name'];            //临时存储位置
        $size = $_FILES[$fileField]['size'];                    //文件大小
        $error = $_FILES[$fileField]['error'];                  //上传错误号
        
        //多文件上传，返回数组形式
        if(is_array($name)){
           $errors = array();
           //检查多文件上传,只做检查，不上传
           for($i=0; $i < count($name); $i++){
               //设置文件信息
               if($this->SetFiles($name[$i], $tmp_name[$i], $size[$i], $error[$i])){
                   //根据刚刚获得是数据，检测各个数据情况，并将错误信息存放到数组中
                   if(!$this->CheckFileSize() || !$this->CheckFileType()){
                       //有错误,设置标识位
                       $errors[] = $this->GetError();
                       $return = FALSE;
                   }
               }else{
                   //上传错误的收集
                   $errors[] = $this->GetError();
                   $return = FALSE;
               }
               //为下一组循环重置参数
               if(!$return){
                   $this->SetFiles();
               }
           }
           
           //返回的数据没有问题时候的处理
           if($return){
               //该数组保存上传后的文件名
               $fileNames = array();
               
               //都是合法的情况下，循环上传文件
               for($i = 0; $i < count($name); $i++){
                   $this->num = $i;
                   //设置文件上传过程中的参数
                   if($this->SetFiles($name[$i], $tmp_name[$i], $size[$i], $error[$i])){
                        //获得新的文件名
                        $this->setNewFileName();
                        //转存文件
                        if(!$this->CopyFile()){
                            //文件移动出错
                            $errors[] = $this->GetError();
                            $return = FALSE;
                        }
                        $fileNames[] = $this->newFileName;
                   }
               }
               $this->newFileName = $fileNames;
           }
           $this->errorMessage = $errors;
           return $return;
        //单文件上传处理    
        }else {
           //设置文件信息
           if($this->SetFiles($name, $tmp_name, $size, $error)){
               //检测文件大小和类型
               if($this->CheckFileSize() && $this->CheckFileType()){
                   //设置新的文件名
                   $this->setNewFileName();
                   //上传成功返回0, 小于0都失败
                   if($this->CopyFile()){
                       return TRUE;
                   }else {
                       $return = FALSE;
                   }
               }else {
                   $return = FALSE;
               }
           }else{
               $return = FALSE;
           }
           //如果标记位为false,则出错，将错误信息保存到errorMesage中
           if(!$return){
               $this->errorMessage = $this->GetError();
           }
           return $return;
        }       
    }
    
    /**
    * 描述: 去除没有上传内容的空白位并将索引重排
    * @date: 2016年4月20日 上午10:58:14
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    private function ClearEmpty($fileField){
        $len = count($_FILES[$fileField]['name']);
        //删除所有空白数据        
        for ($i=0; $i<$len; $i++){
            if(empty($_FILES[$fileField]['name'][$i])){
                unset($_FILES[$fileField]['name'][$i]);
                unset($_FILES[$fileField]['type'][$i]);
                unset($_FILES[$fileField]['tmp_name'][$i]);
                unset($_FILES[$fileField]['error'][$i]);
                unset($_FILES[$fileField]['size'][$i]);
            }
        }
        //重建索引
        $_FILES[$fileField]['name'] = array_merge($_FILES[$fileField]['name']);
        $_FILES[$fileField]['type'] = array_merge($_FILES[$fileField]['type']);
        $_FILES[$fileField]['tmp_name'] = array_merge($_FILES[$fileField]['tmp_name']);
        $_FILES[$fileField]['error'] = array_merge($_FILES[$fileField]['error']);
        $_FILES[$fileField]['size'] = array_merge($_FILES[$fileField]['size']);
    }
    
   
    /**
    * 描述: 获得文件上传后新的文件名称
    * @date: 2016年4月19日 下午7:53:11
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return: 返回文件上传后的名称
    */
    function GetFileName(){
        return $this->newFileName;
    }
    
    
    /**
    * 描述: 返回上传失败后的信息
    * @date: 2016年4月19日 下午7:54:28
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return: 返回上传失败后的信息
    */
    function GetErrorMsg(){
        return $this->errorMessage;
    }
    
    /**
    * 描述: 设置上传出错信息
    * @date: 2016年4月19日 下午7:55:29
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return: 返回错误信息
    */    
    private function GetError(){
        $str = "";
        
        switch ($this->errorNum){
            case 4:
                $str .= "没有文件被上传";
                break;
            case 3:
                $str .= "文件只有部分被上传";
                break;
            case 2:
                $str .= "上传文件的大小超过了表单中规定";
                break;
            case 1:
                $str .= "文件大小超过系统规定";
                break;
            case -1:
                $str .= "不被允许上传的类型";
                break;
            case -2:
                $str .= "上传文件太大";
                break;
            case -3:
                $str .= "上传失败";
                break;
            case -4:
                $str .= "不能建立临时存放目录";
                break;
            case -5:
                $str .= "必须指定上传到大路径";
                break;
            default:
                $str .= "未知错误";
                break;
        }
        return $str;
    } 
    
    /**
    * 描述: 设置和$_FILES相关的信息
    * @date: 2016年4月19日 下午7:56:28
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    private function SetFiles($name="", $tmp_name="", $size=0, $error=0){
        //直接设置上传的错误
        $this->SetOption('errorNum', $error);
        if($error){
            return FALSE;
        }
        
        //设置原文件名
        $this->SetOption('originName', $name);
        //临时文件名
        $this->SetOption('tmpFileName', $tmp_name);
        //获得后缀
        $arrstr = explode(".", $name);
        //文件类型
        $len = count($arrstr)-1;
        $this->SetOption('fileType', strtolower($arrstr[$len]));
        $this->SetOption('fileSize', $size);
        return true;
    }
    
    
    /**
    * 描述: 为单个属性设置值,例如错误号
    * @date: 2016年4月19日 下午7:58:02
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    private function SetOption($key, $val){
        $this->$key = $val;
    }
    
    
    /**
    * 描述: 设置上传后的文件名称
    * @date: 2016年4月19日 下午7:59:06
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    private function setNewFileName(){
        //检查是否需要随机名
        if($this->isRandname){
            $this->SetOption('newFileName', $this->ProRandName());
        }else{
            $this->SetOption('newFileName', $this->originName);
        }
    }
    
    /**
    * 描述: 检测上传的文件是否是合法的类型
    * @date: 2016年4月19日 下午8:00:14
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return: 返回合法性结果
    */
    private function CheckFileType(){
        if(in_array(strtolower($this->fileType), $this->allowType)){
            return true;
        }else{
            $this->SetOption('errorNum', -1);
            return false;
        }
    }
    
    
    /**
    * 描述: 检测文件上传是否是允许的大小
    * @date: 2016年4月19日 下午8:06:09
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    private function CheckFileSize(){
        if ($this->fileSize > $this->maxSize){
            $this->SetOption('errorNum', -2);
            return false;
        }else{
            return true;
        }
    }
    
    /**
    * 描述: 检测是否有上传的目录
    * @date: 2016年4月19日 下午8:07:17
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    private function CheckFilePath(){
        if(empty($this->path)){
            $this->SetOption('errorNum', -5);
            return FALSE;
        }
        //文件爱你路径不存在或文件没有写权限就创建新的
        if(!file_exists($this->path) || !is_writeable($this->path)){
            //尝试创建,并指定权限
            if(!@mkdir($this->path, 0755)){
                //创建失败
                $this->SetOption('errorNum', -4);
                return FALSE;
            }
        }
        return TRUE;
    }
    
    
    /**
    * 描述: 设置随机文件名
    * @date: 2016年4月19日 下午8:10:36
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    private function ProRandName(){
        $filename = $_SESSION['user']['userid'].'_'.$this->num.'_'.date('ymdHis').'_'.rand(100, 999);
        return $filename.'.'.$this->fileType;
    }
    
    
    /**
    * 描述: 复制文件到指定的位置
    * @date: 2016年4月19日 下午8:11:26
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    private function CopyFile(){
        if(!$this->errorNum){
            $path = trim($this->path,'/').'/';
            $path .= $this->newFileName;
            if(@move_uploaded_file($this->tmpFileName, $path)){
                return true;
            }else{
                $this->SetOption('errorNum', -3);
                return false;
            }
        } else {
            return false;
        }
    }  
}
?>
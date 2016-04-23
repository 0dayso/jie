<?php
namespace Xin;
/**
* 文件描述: 用php自身实现伪页面静态化
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月9日 上午9:07:01
* @version 1.0.0
* @copyright  CopyRight
*/

class Pathinfo{
    /**
    * 描述： 截取PATH_INFO中的各个部分内容
    * tags
    * @return $action 对PATH_INFO组装后的数组
    * @author xinbingliang
    * @date 2016年4月9日上午9:44:15
    * @version v1.0.0
    */
    static function GetInfo(){
        $pathInfo = isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:'index';
        $pathInfo = trim($pathInfo, '/&');        
        /* file_put_contents(ROOT.'message.txt', $pathInfo); */
        $infoArray = explode('/', $pathInfo);
        $action['controller'] = !empty($infoArray[0])?$infoArray[0]:'index';
        $str = !empty($infoArray[1])?$infoArray[1]:'index';
        $meth = explode('&', $str);
        $action['action'] = $meth['0'];
        /* file_put_contents(ROOT.'message.txt', '1'.$action['controller'].$action['action']); */ 
        //对所带数据进行获取
        if(isset($meth[1])){
            //去除活动方法
            for($i=1; $i < count($meth); $i++){
                $mirdata = explode('=', $meth[$i]);
                if(!empty($mirdata[0]) && !empty($mirdata[1])){
                    $key = $mirdata[0];
                    $value = $mirdata[1];
                    $action['data'][$key] = $value;
                }
            }
                        
/*             $data = $meth[1];
            $data = explode('&', $data);
            foreach ($data as $value){
             $mirdata = explode('=', $value);
                if(!empty($mirdata[0]) && !empty($mirdata[1])){
                    $key = $mirdata[0];
                    $value = $mirdata[1];
                    $action['data'][$key] = $value;
                }
             }     */
        }else{
            $action['data'] = null; 
        }
        return $action; 
    }
}

?>
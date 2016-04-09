<?php
namespace Xin;

/**
* 文件描述: 全局的注册树,使全局取用数据更为简单
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月9日 下午8:59:44
* @version 1.0.0
* @copyright  CopyRight
*/
class Register{
    private static $instance = NULL;
    private $values = array();
    
    private function __construct(){}
    
    public static function Instance(){
        if(self::$instance == NULL){
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function GetValue($key){
        if(isset($this->values[$key])){
            return $this->values[$key];
        }
        return null;
    }
    
    public function SetValue($key, $value){
        $this->values[$key] = $value;
    }
}
?>
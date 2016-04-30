<?php
namespace Admin\Model;
/**
* 文件描述: 用户管理操作类
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月30日 下午2:58:17
* @version 1.0.0
* @copyright  CopyRight
*/
class Userhelp{
    /**
    * 描述: 首次次进入时获取数据
    * @date: 2016年4月30日 下午3:06:47
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    static function GetUser(){
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $numall = $db->FetchNum('select * from j_user');
        $_SESSION['userallnum'] = $numall;
        $_SESSION['userpage'] = 0;
        $data = self::GetData(0, 1);
        return $data;
    } 
    
    /**
    * 描述: 指定获取数据的开始位置和结束位置
    * @date: 2016年4月30日 下午3:07:22
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    static function GetData($start, $num){
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $array = array('userid', 'username', 'userimg', 'email', 'qq', 'address', 'tel', 'point');
        $data = $db->FetchAll('user', NULL, $array, " limit $start, $num ", ' order by logintime desc ');
        return $data;
    }
    
}

?>
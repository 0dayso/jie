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
    * 描述: 指定获取数据的开始位置和结束位置,或取数据
    * @date: 2016年4月30日 下午3:07:22
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    static function GetData($start, $num){
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $array = array('userid', 'username', 'userimg', 'email', 'qq', 'address', 'tel', 'point', 'userlock');
        $data = $db->FetchAll('user', NULL, $array, " limit $start, $num ", ' order by time desc ');
        return $data;
    }
    
    /**
    * 描述: 获得相关数据
    * @date: 2016年5月1日 上午9:59:53
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    static function UserData(){
        $register = \Xin\Register::Instance();
        $data = $register->GetValue('data');
        return $data;
    }
    
    
    /**
    * 描述: 管理员管理密码输入后,的操作
    * @date: 2016年5月1日 上午10:41:05
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    static function Adminhadle(){
        //清理字符串
        //管理员Id
        $adminid = $_SESSION['adminid'];
        $userid = $_POST['userid'];
        $action = $_POST['action'];
        $password = \App\Model\ClearString::IsNone($_POST['passwd']);
        $password = \App\Model\ClearString::ReturnClear($password);
        //密码加密
        $password = \App\Model\Encrypt::md5_crypt($password);  
        //获得数据库对象
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        //密码对比
        $where = ' adminid = '.$adminid.' and adpassword = "'.$password.'" ';
        $data = $db->FetchAll('admin', $where);
        if(empty($data)){
            return "修改失败";
        }
        
        try{
            switch ($action){
                case 'lock':
                    $where = " userid = {$userid} ";
                    $db->Update('user', array('userlock'=>1), $where);
                    break;
                case 'unlock':
                    $where = " userid = {$userid} ";
                    $db->Update('user', array('userlock'=>0), $where);
                    break;
                case 'del':
                    return "该功能暂时不开放";
                    $where = " userid = {$userid} ";
                    $db->Delete('user', $where);
                    break;
                default:
                    throw new \Exception('未知操作类型');
                    break;
            }
        }catch(\Exception $e){
            return $e->getMessage();
        }
        //操作数据库
        
        return "操作成功";
    }
    
    
}

?>
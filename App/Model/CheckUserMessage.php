<?php
/**
* 文件描述: 用户数据检测，可能在内存中重复创建建议使用单例
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月15日 下午5:07:21
* @version 1.0.0
* @copyright  CopyRight
*/
namespace App\Model;

class CheckUserMessage{
    //保存自身
    public static $insatnce = NULL;
    //使用单例
    private function __construct(){} 
    
    //获得自身
    static public function GetSelf(){
        if(self::$insatnce == NULL){
           self::$insatnce = new self();
        }
            return self::$insatnce;
    }
    
    
    /**
    * 描述: 去除数据两边的空格,并检测数据是否为空。这里应该使用封装好的字符串处理方法重构下
    * @date: 2016年4月16日 上午6:36:25
    * @author: xinbingliang <709464835@qq.com>
    * @param: $type 要检查的数据在数组中的名称
    * @param: variable
    * @param: variable
    * @return:
    */
    public function CheckEmpty($type){
        if(isset($_SESSION['reg'][$type])){
            $_SESSION['reg'][$type] = trim($_SESSION['reg'][$type]);
        }else{
            return $type.'未设置';
        }
        if(empty($_SESSION['reg'][$type])){
            return $type."为空";
        }
        return NULL;
    }
    
    
    /**
    * 描述: 注册时检测所有信息是否完备
    * @date: 2016年4月17日 上午9:22:45
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    public function CheckReg(){
        //应该存储的字段是否都存在
        $key = array('idcard', 'idaddress', 'birthday', 'time', 'gender', 'username', 'email', 'password');
        foreach ($key as $value){
            $message = $this->CheckEmpty($value);
            if(!empty($message)){
                return "字段并未设置完全";
            }
        }
        
        //对密码加密
        $_SESSION['reg']['password'] = Encrypt::md5_crypt($_SESSION['reg']['password']);        
        //数据写入数据库
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $db->Insert('user', $_SESSION['reg']);
        return NULL;
    }


    /** 注册时验证身份证号码，并根据号码获得其他用户个人性信息
    * 描述:
    * @date: 2016年4月17日 上午9:30:59
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    public function CheckIdcard(){
        //去身份证输入两边空格
        $emptyMessage = $this->CheckEmpty('idcard');
        if(empty($emptyMessage)){
            if ((preg_match("/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$/", $_SESSION['reg']['idcard'])) || (preg_match("/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}(\d|x|X)$/",  $_SESSION['reg']['idcard']))){
                //判断身份信息是否已经使用过
                $cryptIdcard = Encrypt::md5_crypt($_SESSION['reg']['idcard']);
                //获得数据库的对象
                $register = \Xin\Register::Instance();
                $db = $register->GetValue('db');
                
                //编写查询语句
                $sql = "select * from j_user where idcard = '{$cryptIdcard}'";
                //对结果判断
                $res = $db->FecthAllNum($sql);
                if(empty($res)){
                    //通过身份证去获得其他身份信息
                    $true = CheckTrue::GetMessage(); 
                    return $true;
                }else {
                    return "身份证已经被注册";
                }
            }else{
                return "身份证格式不正确";
            }
        }else{
            return "身份证没有设置";
        }
    }
    
    
    /**
    * 描述: 注册时检测用户名是否正确
    * @date: 2016年4月17日 上午9:32:04
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function CheckUsername(){
        //为空检测
        $emptyUsername = $this->CheckEmpty('username');
        if (!empty($emptyUsername)){
            return "用户名还没有设置";  
        }
        
        $len = strlen($_SESSION['reg']['username']);
        if($len<2 || $len>12){
            return '用户名错误';
        }
    }
    
    
    /** 检测用户登录和注册时邮箱的合法性
    * 描述:
    * @date: 2016年4月17日 上午9:32:34
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    public function CheckEmail(){
        //判断是否为空
        $emptyMessage = $this->CheckEmpty('email');
        if(empty($emptyMessage)){
            //邮件格式判断
            if(preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i", $_SESSION['reg']['email'])){
                //获得数据库的对象
                $register = \Xin\Register::Instance();
                $db = $register->GetValue('db');
    
                //编写查询语句
                $sql = "select * from j_user where email = '{$_SESSION['reg']['email']}'";
                //对结果判断
                $res = $db->FecthAllNum($sql);
                //没有被注册过才返回null
                if(empty($res)){
                    return null;
                }else{
                    return "邮件已经被注册";
                }
            }else{
                return "邮件格式不合法";
            }
        }else{
            return "邮件没有设置";
        }
    }
    
    
    /**
    * 描述: 登录按钮被点击的时候的检测
    * @date: 2016年4月17日 上午9:33:58
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function CheckLog(){
        $time = array('logintime'=>time());
        
        //获取数据库对象
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        
        //编写查询语句
        $sql = "select * from j_user where password = '{$_SESSION['reg']['password']}' and email = '{$_SESSION['reg']['email']}'";
        //对结果判断
        $res = $db->FecthAllNum($sql);
        
        if(!empty($res)){
            $db->Update('user', $time," email='{$_SESSION['reg']['email']}'");
            return NULL;
        }else{
            return "登录失败，请重新登录";
        }

    }
    
    
    /**
    * 描述: 登录时检查用户密码在数据库中是否存在
    * @date: 2016年4月17日 上午9:33:14
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function CheckPassword(){
        if(strlen($_SESSION['reg']['password']) >= 6){
            //密码加密
            $_SESSION['reg']['password'] = Encrypt::md5_crypt($_SESSION['reg']['password']);
            //密码比对
            $register = \Xin\Register::Instance();
            $db = $register->GetValue('db');
    
            //编写查询语句
            $email = empty($_SESSION['reg']['email'])?'000000000':$_SESSION['reg']['email'];
            $password = empty($_SESSION['reg']['password'])?'000000000':$_SESSION['reg']['password'];
            $sql = "select * from j_user where password = '{$_SESSION['reg']['password']}' and email = '{$email}'";
            //对结果判断
            $res = $db->FecthAllNum($sql);
            //没有被注册过才返回null
            if(empty($res)){
                return '密码错误';
            }else{
                return NULL;
            }
        }else {
            return '密码太弱了';
        } 
    }
    
    
    /**
     * 描述: 不论登录或者注册成功后，根据邮箱获得用户的信息,并保存到session中
     * @date: 2016年4月17日 上午10:08:04
     * @author: xinbingliang <709464835@qq.com>
     * @param: variable
     * @return:
     */
    function getMessage(){
        $register = \Xin\Register::Instance();
        $db = $register->GetValue('db');
        $email = $_SESSION['reg']['email'];
        $where = "email = '{$email}'";
        $data = $db->FetchAll('user', $where);
        $_SESSION['user']['userid'] = $data[0]['userid'];
        $_SESSION['user']['username'] = $data[0]['username'];
        $_SESSION['user']['userimg'] = $data[0]['userimg'];
        //清空注册和登录信息
        $_SESSION['reg'] = NULL;
    }
}
?>
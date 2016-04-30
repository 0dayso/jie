<?php
namespace Admin\Controller;
/**
* 文件描述: 管理员信息操作控制器
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月29日 下午9:19:47
* @version 1.0.0
* @copyright  CopyRight
*/
class Admin{
    /**
    * 描述: 读取所有管理员信息
    * @date: 2016年4月29日 下午9:25:30
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function Index(){
        $data = \Admin\Model\AdminHelp::Index(); 
        include ROOT.'Admin/View/admin.html';
    }
    
    
    /**
    * 描述: 修改管理员
    * @date: 2016年4月29日 下午9:23:09
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function Change(){
        //获取管理员id
        $register = \Xin\Register::Instance();
        $data = $register->GetValue('data');
        //获取用户信息
        $adminmess = \Admin\Model\AdminHelp::GetAdmin($data); 
        
        include ROOT.'Admin/View/adminform.html';
        /* $path = "http://localhost/jie/admin.php/Admin/ChangSub&adminid={$adminmess['adminid']}"; */
    }
    
    
    /**
    * 描述: 添加管理员
    * @date: 2016年4月29日 下午10:33:12
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function AddAdmin(){
        include ROOT.'Admin/View/adminform.html';
        //定义执行位置
        /* $path = "http://localhost/jie/admin.php/Admin/ChangSub&adminid={$adminmess['adminid']}"; */
    }
    
    
    /**
    * 描述: 提交用户信息表单
    * @date: 2016年4月30日 上午9:46:17
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function SubAdmin(){
        \Admin\Model\AdminHelp::SubAdmin();
        $this->Index();
    }
    
}

?>
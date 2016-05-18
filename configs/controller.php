<?php
$controller = array(
    //首页控制器和方法
    'Index'=>array('Index', 'CheckIdcard', 'CheckName', 'CheckPassword', 'CheckEmail', 
        'Reg', 'LogEmail', 'LogPassword', 'Log', 'LogOut', 'Code', 'Login', 'EnableMail'),
    //商品发布控制器和方法
    'PushGoods'=>array('Index', 'PushName', 'PushgDepict', 'PayNum', 'SubmitFile'),
    //异步加载商品控制器和方法
    'Show'=>array('Index', 'Free', 'More', 'Pay'),
    //商品详情页控制器和方法
    'Goods'=>array('Index', 'PushDis', 'Pre', 'Nex', 'Zambia', 'Want', 'UserListpre', 'UserListnex', 'Chico'),
    //用户页
    'User'=>array('Index', 'QQChange', 'QQChange', 'AddChange', 'EmailChange', 'TelChange', 
        'CheckPassword', 'ChangePassword', 'PushDis'),
    //用户异步加载操作
    'UserMore'=>array('PreDis', 'NexDis', 'PreGoods', 'NexGoods'),
    //聊天操作
    'Chat'=>array('Index', 'AddChatUser', 'PushChat', 'GetChat', 'UserNum', 'ActiveChat'),
    
    /*---------------------------------------------------------*/
    //管理员操作
    'Admin'=>array('Index', 'Change', 'AddAdmin', 'SubAdmin'),
    //用户管理操作
    'TubeUser'=>array('Index', 'PreUser', 'NexUser', 'UserTube', 'SuerTubUser'),
    //用户商品管理
    'GoodsTube'=>array('Index'),
);

return $controller;


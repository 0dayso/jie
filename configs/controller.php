<?php
$controller = array(
    //首页控制器和方法
    'Index'=>array('Index', 'CheckIdcard', 'CheckName', 'CheckPassword', 'CheckEmail', 
        'Reg', 'LogEmail', 'LogPassword', 'Log', 'LogOut'),
    //商品发布控制器和方法
    'PushGoods'=>array('Index', 'PushName', 'PushgDepict', 'PayNum', 'SubmitFile'),
    //异步加载商品控制器和方法
    'ShowGoods'=>array('Index', 'GetFree', 'GetMore'),
    //商品详情页控制器和方法
    'Goods'=>array('Index')
);

return $controller;


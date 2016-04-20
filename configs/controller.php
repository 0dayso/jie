<?php
$controller = array(
    'Index'=>array('Index', 'CheckIdcard', 'CheckName', 'CheckPassword', 'CheckEmail', 
        'Reg', 'LogEmail', 'LogPassword', 'Log', 'LogOut'), 
    'PushGoods'=>array('Index', 'PushName', 'PushgDepict', 'PayNum', 'SubmitFile'),
);

return $controller;


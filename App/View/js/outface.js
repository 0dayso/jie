$(function(){
    'use strict';
    var flag = 0;
    /*点击注册*/
    $('#register').click(function () {
        $('.registerform').fadeIn(500);
    });
    /*点击登录*/
    $('#login').click(function () {
        $('.loginform').fadeIn(500);
    });
    /*关闭注册框*/
    $('#closeregister').click(function () {
        $('.registerform').fadeOut(100);
    });
    /*关闭登录框*/
    $('#closelogin').click(function () {
        $('.loginform').fadeOut(100);
    });

    /*对身份证号码长度验证，通过后使用$.post提交验证数据，到服务端去验证*/
    $('#idcard').blur(function () {
        var idvalue = $(this).val();
        idvalue = idvalue.replace(/(^\s*)|(\s*$)/g,'');
        var len = idvalue.length;
        if(len ==15 || len ==18){
            $.post('index.php/index/CheckIdcard',{"idcard":idvalue},function (data) {
                //判断返回信息，并向用户展示
                if(data == null || data== undefined || data == ''){
                    $('#idcardmessage').css('color', '#abcdef').html('身份证正确');
                }else{
                    $('#idcardmessage').css('color', 'red').html(data);
                }
            });
        }else{
            $('#idcardmessage').css('color', 'red').html('身份证错误');
        }
    });

    /* 对邮件的进行验证 */
    $('#email').blur(function () {
        var emailvalue = $(this).val();
        emailvalue = emailvalue.replace(/(^\s*)|(\s*$)/g,'');
        var pattern = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
        var flag = pattern.test(emailvalue);
        if(flag){
            $.post('index.php/index/CheckEmail',{"email":emailvalue}, function (data) {
                if(data == null || data== undefined || data == ''){
                    $('#emailmessage').css('color', '#abcdef').html('邮件正确');
                }else{
                    $('#emailmessage').css('color', 'red').html(data);
                }
            });
        }else{
            $('#emailmessage').css('color', 'red').html('邮件格式有误');

        }
    });

    /*注册对用户名做检测*/
    $('#username').blur(function () {
        var namevalue = $(this).val();
        namevalue = namevalue.replace(/(^\s*)|(\s*$)/g,'');
        if(namevalue.length<2 || namevalue.length>12){
            $('#namemessage').css('color', 'red').html('请数输入正确的姓名');
        }else{
            $.post('index.php/index/CheckName',{'username':namevalue},function (data) {
                if(data == null || data== undefined || data == ''){
                    $('#namemessage').css('color', '#abcdef').html('正确');
                } else {
                    $('#namemessage').css('color', 'red').html(data);
                }
            });

        }
    });

    /*注册对密码做长度检测*/
    $('#password').blur(function () {
        var passwordvalue = $(this).val();
        passwordvalue = passwordvalue.replace(/(^\s*)|(\s*$)/g,'');
        if(passwordvalue.length<6){
            $('#passwordmessage').css('color', 'red').html('密码太弱了');
        }else{
            $.post('index.php/index/CheckPassword',{'password':passwordvalue},function (data) {
                if(data == null || data== undefined || data == ''){
                    $('#passwordmessage').css('color', '#abcdef').html('正确');
                } else {
                    $('#passwordmessage').css('color', 'red').html(data);
                }
            });
        }
    });

    /* 登录时验证邮箱 */
    $('#lemail').blur(function () {
        var emailvalue = $(this).val();
        emailvalue = emailvalue.replace(/(^\s*)|(\s*$)/g,'');
        var pattern = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
        var flag = pattern.test(emailvalue);
        if(flag){
            $.post('index.php/index/LogEmail',{"email":emailvalue}, function (data) {
                if(data == null || data== undefined || data == ''){
                    $('#lemailmessage').css('color', '#abcdef').html('邮件正确');
                }else{
                    $('#lemailmessage').css('color', 'red').html(data);
                }
            });
        }else{
            $('#lemailmessage').css('color', 'red').html('邮件格式有误');
        }
    });

    /* 登录时验证密码 */
    $('#lpassword').blur(function () {
        var passwordvalue = $(this).val();
        passwordvalue = passwordvalue.replace(/(^\s*)|(\s*$)/g,'');
        if(passwordvalue.length<6){
            $('#lpasswordMessage').css('color', 'red').html('密码错误');
        }else{
            $.post('index.php/index/LogPassword', {'password': passwordvalue},function (data) {
                if(data == null || data== undefined || data == ''){
                    $('#lpasswordMessage').css('color', '#abcdef').html('成功');
                }else{
                    $('#lpasswordMessage').css('color', 'red').html(data);
                }
            });
/*            $('#lpasswordMessage').html('&nbsp;&nbsp;');*/
        }
    });


});
$(function(){
    'use strict';
    var flag = 0;
    //注册框是否已经显示
    var registerflag = false;
    var loginflag = false;
    /*点击注册*/
    $('#register').click(function () {
        if(loginflag == false){
            $('.registerform').fadeIn(500);
            registerflag = true;
        }
        /*$('.content').css({'opacity':'.9','background-color':'rgba(0, 0, 0, .9)'});*/
    });
    /*点击登录*/
    $('#login').click(function () {
        if(registerflag == false){
            $('.loginform').fadeIn(500);
            loginflag = true;
        }
    });
    /*关闭注册框*/
    $('#closeregister').click(function () {
        $('.registerform').fadeOut(100);
        registerflag = false;
    });
    /*关闭登录框*/
    $('#closelogin').click(function () {
        $('.loginform').fadeOut(100);
        $('.searchbutton').css('display', 'inline-block');
        loginflag = false;
    });
/*==========================================================*/
    /* 点击展示搜索框 */
    $('.icon-search').click(function () {
        $(this).css('color', 'coral');
        $('.search').animate({width: '70%'},"slow");
    });
/*==========================================================*/
    //各个输入框成功或失败的标记位
    var idflag = false;
    var emailflag = false;
    var nameflag = false;
    var passflag = false;

    /* 各个标记位都是true时才返回true,否则返回false,并设置按钮的样式 */
    function ReFlag() {
        if(idflag == true && emailflag == true && nameflag == true && passflag == true){
          /*  alert('应该变红');*/
            $('.rigistersubmit').css({'background-color':'#ec5252', 'border-color':'#ec5252', 'cursor':'pointer'});
            return true;
        }else{
          /*  alert('不会变红');*/
            $('.rigistersubmit').css({'background-color':'#f1f1f1', 'border-color':'#f1f1f1', 'cursor':'auto'});
            return false;
        }
    }

    /*对身份证号码长度验证，通过后使用$.post提交验证数据，到服务端去验证*/
    $('#idcard').blur(function () {
        var idvalue = $(this).val();
        idvalue = idvalue.replace(/(^\s*)|(\s*$)/g,'');
        var len = idvalue.length;
        if(len ==15 || len ==18){
            $.post('http://localhost/jie/index.php/Index/CheckIdcard',{"idcard":idvalue},function (data) {
                //判断返回信息，并向用户展示
                if(data['errrno'] != 0){
                    idflag = false;
                    $('#idcardmessage').html(data['errormess']);
                }else{
                  /*  alert('身份证成功');*/
                    idflag = true;
                    $('#idcardmessage').html('&nbsp;');
                    ReFlag();
                }
                /*console.log(data);*/
/*                if(data == null || data== undefined || data == ''){
                    idflag = true;
                    /!*$('#idcardmessage').css('color', '#abcdef').html('身份证正确');*!/
                }else{
                    $('#idcardmessage').html(data);
                    idflag = false;
                }*/
            }, 'json');
        }else{
            $('#idcardmessage').html('身份证错误');
            idflag = false;
        }
    });

    /* 对邮件的进行验证 */
    $('#email').blur(function () {
        var emailvalue = $(this).val();
        emailvalue = emailvalue.replace(/(^\s*)|(\s*$)/g,'');
        var pattern = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
        var flag = pattern.test(emailvalue);
        if(flag){
            $.post('http://localhost/jie/index.php/index/CheckEmail',{"email":emailvalue}, function (data) {
                if(data['errno'] != 0){
                   /* console.log(data);*/
                    $('#emailmessage').html(data['errmess']);
                    emailflag = false;
                }else {
                   /* alert('邮件成功');*/
                    emailflag = true;
                    $('#emailmessage').html('&nbsp');
                    ReFlag();
                }
            }, 'json');
        }else{
            emailflag = false;
            $('#emailmessage').html('邮件格式有误');
        }
    });

    /*注册对用户名做检测*/
    $('#username').blur(function () {
        var namevalue = $(this).val();
        namevalue = namevalue.replace(/(^\s*)|(\s*$)/g,'');
        if(namevalue.length<2 || namevalue.length>12){
            $('#namemessage').html('请数输入正确的姓名');
            nameflag = false;
        }else{
            $('#namemessage').html('&nbsp;');
            $.post('http://localhost/jie/index.php/index/CheckName',{'username':namevalue},function (data) {
                if(data['errno'] != 0){
                   /* console.log(data);*/
                    $('#namemessage').html(data['errmess']);
                    nameflag = false;
                }else {
                   /* alert('用户名成功');*/
                    nameflag = true;
                    $('#namemessage').html('&nbsp;');
                    ReFlag();
                }
            },'json');

        }
    });

    /*注册对密码做长度检测*/
    $('#password').blur(function () {
        var passwordvalue = $(this).val();
        passwordvalue = passwordvalue.replace(/(^\s*)|(\s*$)/g,'');
        if(passwordvalue.length<6){

            $('#passwordmessage').html('密码太弱了');
        }else{
            $('#passwordmessage').html('&nbsp;');
            $.post('http://localhost/jie/index.php/index/CheckPassword',{'password':passwordvalue},function (data) {
                if(data['errno'] != 0){
                   /* console.log(data);*/
                    $('#passwordmessage').html(data['errmess']);
                    passflag = false;
                }else {
                    /*alert('密码成功');*/
                    passflag = true;
                    $('#passwordmessage').html('&nbsp;');
                    ReFlag();
                }
/*                if(data == null || data== undefined || data == ''){
                    $('#passwordmessage').css('color', '#abcdef').html('正确');
                } else {
                    $('#passwordmessage').css('color', 'red').html(data);
                }*/
            }, 'json');
        }
    });

    /* 监听表单提交，根据情况决定是否提交 */
    $('.registerform').submit(function () {
        if(ReFlag() == true){
            return true;
        }else{
            return false;
        }
    });

/*==========================================================*/
    function LogFlg() {
        if(lemailflag == true && lpasswordflag == true){
            $('.loginsubmit').css({'background-color':'#ec5252', 'border-color':'#ec5252', 'cursor':'pointer'});
            return true;
        } else {
            $('.loginsubmit').css({'background-color':'#f1f1f1', 'border-color':'#f1f1f1', 'cursor':'auto'});
            return false;
        }
    }

    var lemailflag = false;
    var lpasswordflag = false;
    /* 登录时验证邮箱 */
    $('#lemail').blur(function () {
        var emailvalue = $(this).val();
        emailvalue = emailvalue.replace(/(^\s*)|(\s*$)/g,'');
        var pattern = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
        var flag = pattern.test(emailvalue);
        if(flag){
            $.post('http://localhost/jie/index.php/index/LogEmail',{"email":emailvalue}, function (data) {
                if(data['errno'] != 0){
                    $('#lemailmessage').html(data['errmess']);
                    lemailflag = false;
                    LogFlg();
                }else {
                    /*alert('密码成功');*/
                    lemailflag = true;
                    $('#lemailmessage').html('&nbsp;');
                    LogFlg();
                }
                /*if(data == null || data== undefined || data == ''){
                    $('#lemailmessage').css('color', '#abcdef').html('邮件正确');
                }else{
                    $('#lemailmessage').css('color', 'red').html(data);
                }*/
            }, 'json');
        }else{
            $('#lemailmessage').html('邮件格式有误');
            lemailflag = false;
        }
    });

    /* 登录时验证密码 */
    $('#lpassword').blur(function () {
        var passwordvalue = $(this).val();
        passwordvalue = passwordvalue.replace(/(^\s*)|(\s*$)/g,'');
        if(passwordvalue.length<6){
            $('#lpasswordMessage').html('密码错误');
            lpasswordflag = false;
        }else{
            $.post('http://localhost/jie/index.php/index/LogPassword', {'password': passwordvalue},function (data) {
                if(data['errno'] != 0){
                    /*alert(data['errmess']);*/
                    $('#lpasswordMessage').html(data['errmess']);
                    lpasswordflag = false;
                    LogFlg();
                }else {
                    lpasswordflag = true;
                    $('#lpasswordMessage').html('&nbsp;');
                    LogFlg();
                }
                /*if(data == null || data== undefined || data == ''){
                    $('#lpasswordMessage').css('color', '#abcdef').html('成功');
                }else{
                    $('#lpasswordMessage').css('color', 'red').html(data);
                }*/
            }, 'json');
/*            $('#lpasswordMessage').html('&nbsp;&nbsp;');*/
        }
    });


});
/**
 * Created by Administrator on 2016/4/27.
 * 用户页js
 *
 */
$(function () {
    //点击修改显示文本输入
/*    $('.change').click(function () {
        $(this).prev().replaceWith('<input type="text"/>');
        $(this).html('确定');
    });*/

    //修改qq帐号
    $('#cqq').click(function () {
        if(qqflag == true){
            $.post('http://localhost/jie/index.php/User/QQChange', {"qqstr":qqstr},function (data) {
                $('#cqq').prev().replaceWith('<span class="value namevalue">'+data+'</span>');
                $('#cadd').html('修改');
            });
            return;
        }
        $(this).prev().replaceWith('<input type="text" id="Entqq" onkeyup="enterQQ(this)"/>');
        $(this).html('确定');
    });


    //修改地址
    $('#cadd').click(function () {
        if(addflag == true){
            $.post('http://localhost/jie/index.php/User/AddChange', {"addstr":addstr},function (data) {
                $('#cadd').prev().replaceWith('<span class="value address">'+data+'</span>');
                $('#cadd').html('修改');
            });
            return;
        }
        $(this).prev().replaceWith('<input type="text" id="Entadd" onkeyup="enterAdd(this)"/>');
        $(this).html('确定');
    });


    //修改邮箱
    $('#cemail').click(function () {
        if(emailflag == true){
            $.post('http://localhost/jie/index.php/User/EmailChange', {"emailstr":emailstr},function (data) {
                $('#cemail').prev().replaceWith('<span class="value email">'+data+'</span>');
                $('#cemail').html('修改');
            });
            return;
        }
        $(this).prev().replaceWith('<input type="text" id="Entemail" onkeyup="enterEmail(this)"/>');
        $(this).html('确定');
    });

    //修改电话
    $('#ctel').click(function () {
        if(telflag == true){
            $.post('http://localhost/jie/index.php/User/TelChange', {"telstr":telstr},function (data) {
                $('#ctel').prev().replaceWith('<span class="value tel">'+data+'</span>');
                $('#ctel').html('修改');
            });
            return;
        }
        $(this).prev().replaceWith('<input type="text" id="Enttel"  onkeyup="enterTel(this)"/>');
        $(this).html('确定');
    });


    var passwordflag = false;
    //点击修改密码,显示密码输入
/*    $('#passwordbutton').click(function () {
        $('#passwordbox').slideDown(500);
    });*/

    $('#oldpassword').blur(function () {
        var oldpassword = $(this).val();
        oldpassword = oldpassword.replace(/(^\s*)|(\s*$)/g,'');
        $.post('http://localhost/jie/index.php/User/CheckPassword', {'oldpassword': oldpassword}, function (data) {
            if(data == 'ok'){
                $('#oldpass').html('原密码正确');
                passwordflag = true;
            }else{
                $('#oldpass').html('原密码错误');
                passwordflag = false;
            }
        });
        $('#oldpass').html('原密码正确');
    });

    $('#newpassword').keyup(function () {
        checkNewpassword();
    });
    $('#passwordbutton').click(function () {
        if(passwordflag == true ){
            if(checkNewpassword()){
                $.post('http://localhost/jie/index.php/User/ChangePassword', {'newpassword': newpassword}, function (data) {
                    if(data == 'ok'){
                        alert('修改成功');
                    }else{
                        alert('密码修改失败');
                    }
                });
            }
        }
    });

    var newpassword;
    function checkNewpassword() {
        newpassword = $('#newpassword').val();
        newpassword = newpassword.replace(/(^\s*)|(\s*$)/g,'');
        if(newpassword.length >= 6){
            $('#newpass').html('符合密码要求');
            return true;
        }else{
            $('#newpass').html('密码不合要求');
            return false;
        }
    }

    //对星的选择
    //默认为5星
    var startnum = 5;
    $('.start').click(function () {
        $(this).nextAll().css('color', '#c0c0c0');
        $(this).prevAll().css('color', '#fae150');
        $(this).css('color', '#fae150');
        startnum = $(this).index()+1;
    });


    //点击评论
    $('#userdisub').click(function () {
        var text =  $('#disusertext').val();
        text = text.replace(/(^\s*)|(\s*$)/g,'');
        if(text.length >= 6){
           $.post('http://localhost/jie/index.php/User/PushDis', {"text": text, 'startnum': startnum},function (data) {
                alert(data);
            })
        }else{
            alert('字数太少了');
        }
    });


    
});

//各个修改位置的标记位
//qq输入标记位
var qqflag = false;
//地址输入标记位
var addflag = false;
//邮箱输入标记位
var emailflag = false;
//电话输入标记位
var telflag = false;


//qq输入监听
var qqstr = '';
function enterQQ(qqobj) {
    qqstr = $(qqobj).val();
    var pattern = /^[1-9][0-9]{4,9}$/;
    if(pattern.test(qqstr)){
        qqflag = true;
        $('#cqq').css('color', '#abcdef');
    }else{
        $('#cqq').css('color', '#cccccc');
    }
}


//地址输入监听
var addstr = '';
function enterAdd(addobj) {
    addstr = $(addobj).val();
    addflag = true;
    $('#cadd').css('color', '#abcdef');
}


//邮箱输入监听
var emailstr = '';
function enterEmail(emailobj) {
    emailstr = $(emailobj).val();
    var pattern = /^([0-9A-Za-z\-_\.]+)@([0-9a-z]+\.[a-z]{2,3}(\.[a-z]{2})?)$/g;
    if(pattern.test(emailstr)){
        emailflag = true;
        $('#cemail').css('color', '#abcdef');
    }else{
        $('#cemail').css('color', '#cccccc');
    }
}


//电话输入监听
var telstr = '';
function enterTel(telobj) {
    telstr = $(telobj).val();
    var pattern = /^1[3|4|5|8][0-9]\d{4,8}$/;
    if(pattern.test(telstr)){
        telflag = true;
        $('#ctel').css('color', '#abcdef');
    }else{
        $('#ctel').css('color', '#cccccc');
    }
}


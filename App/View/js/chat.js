/**
 * Created by Administrator on 2016/5/5.
 */
var touserid = null;
var touserimg = null;
var tousername = null;
var selfimg = $('#selfHead').attr('src');
$(function(){
    /*=================聊天滚动条=========================*/
    $('#chatBox').mCustomScrollbar({
        enable: false,
        scrollType: "continuous",
        scrollSpeed: 20,
        scrollAmount: 40,
        scrollTo: 'last'
    });
    /*=================聊天对象滚动条==========================*/
    $('.chatUser').mCustomScrollbar({
        enable: false,
        scrollType: "continuous",
        scrollSpeed: 20,
        scrollAmount: 40
    });
    /*==================点击聊天图标弹出聊天===================*/
    $('#chatbutton').click(function () {
        $('.chatBox').toggle(800, function () {
            //聊天图标亮色
            if($('#chatbutton').hasClass('chaticonactive')){
                $('#chatbutton').removeClass('chaticonactive');
            }else{
                getHistoryList();
                $('#chatbutton').addClass('chaticonactive');
            }
        });

    });
    
    function getHistoryList() {
        $.post('http://localhost/jie/index.php/Chat/Index', {}, function (data) {
            //向聊天对象表中进行填充
            if(!$.isEmptyObject(data)){
                var i = 0;
                var str = '';
                while(true){
                    if($.isEmptyObject(data[i])){
                        break;
                    }
                    if(i == 0){
                        touserid = data[i]['userid'];
                        touserimg = 'http://localhost/jie/headimg/'+data[i]['userimg'];
                        tousername = data[i]['username'];
                        str += '<div class="touserlist"  data-chatuserid="'+data[i]['userid']+'" onmouseover="xshow(this)" onmouseout="xhide(this)" onclick="checktouser(this)"> <img src="http://localhost/jie/headimg/'+data[i]['userimg']+'" class="active" width="30px" height="30px"/> <p><span>'+data[i]['username']+'</span><i class="demo-icon icon-cancel-circled2">&#xe829;</i></p></div>';
                    }else{
                        str += '<div class="touserlist"  data-chatuserid="'+data[i]['userid']+'" onmouseover="xshow(this)" onmouseout="xhide(this)" onclick="checktouser(this)"> <img src="http://localhost/jie/headimg/'+data[i]['userimg']+'" width="30px" height="30px"/> <p><span>'+data[i]['username']+'</span><i class="demo-icon icon-cancel-circled2">&#xe829;</i></p></div>';
                    }
                    i++;
                }
                $('#useradd').html(str);
                //组装聊天记录
                console.log(data['chat']);
                var chatstr = '';
                for (var i in  data['chat']){
                    var time = new Date(parseInt(data['chat'][i]['chattime'])*1000);
                    time = time.getHours()+':'+time.getMinutes();
                    //对方的发言
                    console.log(data['chat'][i]['userid']);
                    if(data['chat'][i]['userid'] == touserid){
                        chatstr += '<article class="other"><img src="'+touserimg+'" width="30px" height="30px"/><p>'+data['chat'][i]['chatcontent']+'<span>'+time+'</span></p></article>';
                    }else{
                        //自己的发言
                        chatstr += '<article class="self"><img  src="'+selfimg+'" width="30px" height="30px"/><p>'+data['chat'][i]['chatcontent']+'<span>'+time+'</span></p></article>';
                    }
                }
                $('#chatBox').html(chatstr);
                //更新滚动轴
                $(".chatBox").mCustomScrollbar("update");
                //滚动到最后
                $(".chatBox").mCustomScrollbar("scrollTo","last");

            }else{
                $('#useradd').html('');
                $('#chatBox').html('');
            }
        }, 'json');
    }

    /*===================选择发送给的用户======================*/
    $('#goodschat').click(function () {
        //获得用户的头像
        touserimg = $('.blown img').attr('src');
        //获得用户的id
        touserid = $('#goodschat').attr('data-chatuserid');
        //获得用户名
        tousername = $('#touserid').html();

        //向对话表中添加新的值
        $.post('http://localhost/jie/index.php/Chat/AddChatUser', {'touserid':touserid},function (data) {});

        getHistoryList();
        $('.chatBox').show(1000);
        GetHistory(touserid);
    });

    /*======================================================*/
    /*====================点击发送消息==========================*/
    //将聊天对象之间的消息推送给服务端
    $('#chatSend').click(function () {
        //获得输入框内部的数据
        var value = $('#chatinput').val();
        //去除两边空格
        value = value.replace(/(^\s*)|(\s*$)/g,'');

        var len = value.length;

        if(len > 0 && len < 120 ){
            $.post('http://localhost/jie/index.php/Chat/PushChat', {'touserid':touserid, 'chat':value}, function (data) {
                //向聊天列表中添加聊天数据
                GetSelfChat(data);
                console.log(data);
            }, 'json');
        }
    });
    /*=====================聊天数据回取===========================*/
    //自己聊天对象列表回取
    function GetSelfChat(chatJson) {
        //获得自己的头像
        var userimg = $('#selfHead').attr('src');
        if(!$.isEmptyObject(chatJson)){
            var str = '<article class="self"><img  src="'+userimg+'" width="30px" height="30px"/><p>'+chatJson.cont+'<span>'+chatJson.date+'</span></p> </article>';
            var obj = $(str);
            //添加数据
            $(".chatBox .mCSB_container").append(obj);
            //更新滚动轴
            $(".chatBox").mCustomScrollbar("update");
            //滚动到最后
            $(".chatBox").mCustomScrollbar("scrollTo","last");
        }
    }
    /*========================================================*/
    /*======================轮训接收消息=========================*/


    /*========================================================*/


});



/*=+=+=+=+=+=+=+=+=+=+=+=+=+=+标签事件绑定=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+*/
//x图标的显示和隐藏
function xshow(tself) {
    $(tself).find('.icon-cancel-circled2').show(0);
}
function xhide(tself) {
    $(tself).find('.icon-cancel-circled2').hide(0);
}

//直接点击用户准备开始聊天
function checktouser(tself) {
    touserid = $(tself).attr('data-chatuserid');
    touserimg = $(tself).find('img').attr('src');
    tousername = $(tself).find('span').html();

    getHistoryList();
    //添加和清除所有活动样式
    var touserlist = $('.touserlist');
    var len = touserlist.length;
    for (var i = 0; i < len; i++){
        var chatuserid = $(touserlist[i]).attr('data-chatuserid');

        if(chatuserid == touserid){
            $(touserlist[i]).find('img').addClass('active');
        } else {
            $(touserlist[i]).find('img').removeClass('active');
        }
    }
}

function Testshow() {
    var touserlist = $('.touserlist');
    var len = touserlist.length;
    for (var i = 0; i < len; i++){
        var chatuserid = $(touserlist[i]).attr('data-chatuserid');

        if(chatuserid == touserid){
            $(touserlist[i]).find('img').addClass('active');
        } else {
            $(touserlist[i]).find('img').removeClass('active');
        }
    }
}





/*=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+*/



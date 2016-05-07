/**
 * Created by Administrator on 2016/5/5.
 */
var touserid = null;
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
                console.log(data);

            }else{
                $('#useradd').html('');
            }
        }, 'json');
    }

    function GetHistory() {
        
    }

    /*===================选择发送给的用户======================*/
    $('#goodschat').click(function () {
        $('.chatBox').show(1000);
        //获得用户的头像
        var touserimg = $('.blown img').attr('src');
        //获得用户的id
        touserid = $('#goodschat').attr('data-chatuserid');
        //获得用户名
        var tousername = $('#touserid').html();


        //已经有的用户列表
        var touserlist = $('.touserlist');
        //该用户是否存在的的标记位
        var issetuserid = false;
        var len = touserlist.length;
        for (var i = 0; i < len; i++){
            var chatuserid = $(touserlist[i]).attr('data-chatuserid');

            if(chatuserid == touserid){
                issetuserid == true;
                return;
            }
        }

        //对话列表中不存在该用户,添加该用户
        if(issetuserid == false){
            var useradd = '<div class="touserlist"  data-chatuserid="'+touserid+'" onmouseover="xshow(this)" onclick="checktouser(this)" onmouseout="xhide(this)"><img src="'+touserimg+'" width="30px" height="30px"/><p><span>'+tousername+'</span><i class="demo-icon icon-cancel-circled2">&#xe829;</i></p> </div>'
            $('#useradd .mCSB_container').prepend(useradd);
            //更新滚动轴
            $("#useradd").mCustomScrollbar("update");
            $("#useradd").mCustomScrollbar("scrollTo","first");
        }

        //为给用户添加活动样式
        var newuserlist = $('.touserlist');
        newuserlist.each(function () {
            var chatuserid = $(this).attr('data-chatuserid');
            if(chatuserid == touserid){
                $(this).children('img').addClass('active');
            }else{
                $(this).children('img').removeClass('active');
            }
        });

        //修改聊天用户列表
        

    });


    /*======================================================*/
    /*====================点击发送消息==========================*/
    //将聊天对象之间的消息推送给服务端
    //获得用户的id
/*    var touserid = $('#goodschat').attr('data-chatuserid');*/




    /*========================================================*/
    /*======================轮训接收消息=========================*/


    /*========================================================*/

/*    $('#add').click(function(){
        $.post('./test.php', {},function(data){
            //添加数据
            $(".content .mCSB_container").append(data);
            //更新滚动轴
            $(".content").mCustomScrollbar("update");
            //滚动到最后
            $(".content").mCustomScrollbar("scrollTo","last");
        });
    });*/
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
function showid(){
    alert(touserid);
}

/*=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+*/



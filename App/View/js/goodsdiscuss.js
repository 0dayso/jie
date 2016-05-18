/**
 * Created by Administrator on 2016/4/23.
 *
 * 商品评论模块
 *
 */
$(function () {
    //输入字数限制
    var flag = false;
    var cont = '';
    $('#entersend').keyup(function () {
        cont = $(this).val();
        //剔除回复标记,仅保留内容
        cont = cont.replace(/#.*?#/g,'');
        //去除两边空格
        cont = cont.replace(/(^\s*)|(\s*$)/g,'');

        var len = cont.length;
        if(len > 120){
            flag = false;
            $('#entermessage').html('超过120个字符');
        }else if(len < 3){
            flag = false;
            $('#entermessage').html('评论太少了');
        }else{
            $('#entermessage').html('&nbsp;&nbsp;');
            flag = true;
        }

    });
    $('#disform').submit(function () {
        //评论
        if(flag == true){
            //被回复者的id
            var touserid = $('#touserid').val();
            if(touserid == undefined){
                var json = {"gdcontent": cont, "touserid": 0};
            }else{
                var json = {"gdcontent": cont, "touserid": touserid}
            }
            /*console.log(json);*/
            //用ajax向远程提交评论数据
            $.post('http://localhost/jie/index.php/Goods/PushDis', json,function (data) {
                if(data != '0'){
                    $('#entermessage').html('评论失败');
                }else{
                    $('#entersend').val('');
                    //自己的用户名
                    var userid = $('#userid').val();
                    var username = $('#username').val();
                    var userimg = $('#fuserimg').attr('src');

                    //向评论显示中添加显示
                    var addstr = '<article><img src="'+userimg+'" width="45px" height="45px"><div class="message"><p>' +
                    '<span>'+username+'</span>:<span>'+cont+'</span></p> <p><span class="distime">刚刚</span>' +
                    '<a data-userid="'+userid+'" data-username="'+username+'" href="#reply" class="reply">回复</a>' +
                    '</p> </div> </article>';
                    $('#comment').prepend($(addstr));
                    //评论数目修改
                    var commentnum = $('#commentnum').html();
                    commentnum = parseInt(commentnum) + 1;
                    $('#commentnum').html(commentnum);
                }
            });
        }
        return false;
    });

/*
*
* 这里有个bug,后添加的元素，无法自我回复,解决办法，将事件直接绑定到元素上
*
* */

    //点击回复时的事件
    $('.reply').on('click', function () {
        /*alert('事件被响应');*/
        var tousername = $(this).attr('data-username');
        var touserid = $(this).attr('data-userid');
        //改变按钮样式
        $('#discuss').val('回复');
        //输入框提示
        var mess = '#'+tousername+'#';
        $('#entersend').css('border-color', 'red').val(mess);
        //向表单中添加被回复者的id
        var hidden = "<input type='hidden' id='touserid' value='"+touserid+"'/>";
        $('#disform').append(hidden)
    })


    /* 评论内容翻页事件监听 */
    $('#pre').on('click', function () {
        $.post('http://localhost/jie/index.php/Goods/Pre', {},function (data) {
            if(data[1] == 'top'){
                InsertMess('没有更多了');
            }else{
                //循环组装显示数据
                var str = '';
                for (var i in data){
                    //touserid记得加上
                    if(data[i]['tousername'] != null){
                        var discontent = '回复<a href="">'+data[i]['tousername']+'</a>:'+data[i]['gdcontent'];
                    }else{
                        var discontent = data[i]['gdcontent'];
                    }
                    //循环组装
                    str += "<article><img src='"+data[i]['userimg']+"' width='45px' height='45px'><div class='message'><p><span>"+data[i]['username']+"</span>:<span>"+discontent+"</span></p> <p><span class='distime'>"+data[i]['gdtime']+"</span><a data-userid='"+data[i]['userid']+"'data-username='"+data[i]['tousername']+"' href='#reply' class='reply'>回复</a></p></div> </article>";
                }

                //清空原来是数据直接添加新数据
                $('#comment').html(str);
            }
        },'json')
    });

    $('#nex').on('click', function () {
        $.post('http://localhost/jie/index.php/Goods/Nex', {},function (data) {
            console.log(data);
            if(data[1] == 'last'){
                InsertMess('没有更多了');
            }else{
                
                //循环组装显示数据
                var str = '';
                for (var i in data){

                   if(data[i]['tousername'] != null){
                        var discontent = '回复<a href="">'+data[i]['tousername']+'</a>:'+data[i]['gdcontent'];
                    }else{
                       var discontent = data[i]['gdcontent'];
                    }

                    //循环组装
                    console.log(data.i);
                    str += "<article><img src='"+data[i]['userimg']+"' width='45px' height='45px'><div class='message'><p><span>"+data[i]['username']+"</span>:<span>"+discontent+"</span></p> <p><span class='distime'>"+data[i]['gdtime']+"</span><a data-userid='"+data[i]['userid']+"'data-username='"+data[i]['tousername']+"' href='#reply' class='reply'>回复</a></p></div> </article>";
                }

                //清空原来是数据直接添加新数据
                $('#comment').html(str);
            }
        }, 'json')
    })

    function DIY(obj) {
        var str = '';
        for (var i in data){
            //循环组装
            str += "<article><img src='"+obj['userimg']+"' width='45px' height='45px'><div class='message'><p><span>"+obj['username']+"</span>:<span>"+obj['gdcontent']+"</span></p> <p><span class='distime'>"+Obj['goodsid']+"</span><a data-userid='"+obj['userid']+"'data-username='"+obj['tousername']+"' href='#reply' class='reply'>回复</a></p></div> </article>";
        }
        //返回组装好的数据
        return str;
    }
    
});
/*
InsertMess('没有更多了');*/

/**
 * Created by Administrator on 2016/5/16.
 * 点赞，获取商品，
 *
 */
/*+==+==+==+==+==+==+==+==点赞功能+==+==+==+==+==+==+==+==+==+==*/
    /*商品列表存在异步添加的，所以点赞功能，要放到外面，适应后添加的元素*/
function Zambia(Tself){
    var goodsid = $(Tself).attr('data-goodsid');
    var oldZambia = $(Tself).children('span').html();
    //向服务端传递点赞信息
    $.post('http://localhost/jie/index.php/Goods/Zambia', {"goodsid": goodsid}, function (data) {
        /*alert(data);*/
        //不论如何都应该替换为实心小手，并描红
        if(data == 'ZambiaTrue'){
            oldZambia = parseInt(oldZambia)+1;
            $(Tself).children('span').html(oldZambia);
        }
        //将小手变成填充的并把小手变成红色
        $(Tself).children('i').replaceWith('<i class="demo-icon icon-thumbs-up-alt">&#xe83a;</i>');
        $(Tself).css('color', '#ffba20');
    });
}

/*+==+==+==+==+==+==+==+==+==+==+==+==+==+==+==+==+==+==+==*/
$(function () {
    /*+==+==+==+==+==+==+==+==+货物获得==+==+==+==+==+==+==+==+==+==*/
    $('#want').click(function () {
        var goodsname = $('#goodsname').html();
        $.post('http://localhost/jie/index.php/Goods/Want',{'goodsname':goodsname}, function (data) {
            if (data == 'TRUE') {
                InsertMess('已经成功通知该用户，建议您点击右侧红色按钮与物主进行沟通！');
                //购物车数目加一，并变红
                var num = $('#want').children('span').html();
                num = parseInt(num)+1;
                $('#want').children('span').html(num).end().css('color', '#ffba20');

            } else if(data == 'FALSE'){
                InsertMess('您已经在申请列表中，求勿重复添加！');
                $('#want').css('color', '#ffba20');
            }

            //将购物描红
            //将用户添加到获得列表中
        })
    });

    /*+==+==+==+==+==+==+==+==+==+希望获得用户列表的翻页==+==+==+==+==+==+==+==+==+==*/
    $('#userlistpre').click(function () {
        $.post('http://localhost/jie/index.php/Goods/UserListpre', {},function (data) {
            /*console.log(data);*/
            if (!$.isEmptyObject(data)) {
                var i = 0;
                var str = '';
                while (!$.isEmptyObject(data[i])){
                    var img = 'http://localhost/jie/headimg/'+data[i][0]['userimg'];
                    var name = data[i][0]['username'];
                    var userid = data[i]['userid'];
                    str += "<li onclick='clickChico(this)'  data-userid='"+userid+"'><img src='"+img+"' width='35px' height='35px'/><span>"+name+"</span></li>";
                    i++;
                }
                $('#userlistbox').html(str);
            }
        }, 'json');
    })

    $('#userlistnex').click(function () {
        $.post('http://localhost/jie/index.php/Goods/UserListnex', function (data) {
            /*console.log(data);*/
            if(!$.isEmptyObject(data)){
                var i = 0;
                var str = '';
                while (!$.isEmptyObject(data[i])){
                    var img = 'http://localhost/jie/headimg/'+data[i][0]['userimg'];
                    var name = data[i][0]['username'];
                    var userid = data[i]['userid'];
                    /*userid*/
                    str += "<li onclick='clickChico(this)' data-userid='"+userid+"'><img src='"+img+"' width='35px' height='35px'/><span>"+name+"</span></li>";
                    i++;
                }
                $('#userlistbox').html(str);
            }
        }, 'json')
    })

    //确定赠予该用户
    $('#chioce').click(function () {
        var userid = $(this).attr('data-userid');
        var goodsname = $('#goodsname').html();
        if(!$.isEmptyObject(userid)){
            $.post('http://localhost/jie/index.php/Goods/Chico', {'userid':userid, 'goodsname':goodsname}, function (data) {
                InsertMess(data);
            });
        }
    });

});

/*+==+==+==+==+==+==+==+==+==+==+所有者选择赠予对象==+==+==+==+==+==+==+==+==+==+==+==*/
function clickChico(Tself) {
    var userid = $(Tself).attr('data-userid');
    $(Tself).addClass('chico');
    $(Tself).siblings().each(function () {
        $(this).removeClass('chico');
    });
    $('#chioce').css('background-color', '#EC5151').html('确定').attr('data-userid',userid);
}
/*+==+==+==+==+==+==+==+==+==+==+==+==+==+==+==+==+==+==+==+==+==+==+==+==+==+==+==*/

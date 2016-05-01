/**
 * Created by Administrator on 2016/4/22.
 * 更多商品请求，异步加载模块
 *
 */

$(function () {
   $('#more').click(function () {
       $.post('http://localhost/jie/index.php/Show/More', null, function (data) {
                //总共的数据长度
           var $num = data.length;
           if($num > 0){
               for(var $i = 0; $i < $num; $i++){
                   //获得单个货物信息
                   var goodsid = data[$i]['goodsid'];
                   var userid = 'http://localhost/jie/index.html/User/Index&userid='+data[$i]['userid'];
                   var goodsimg0 = 'http://localhost/jie/goodsimg/'+data[$i]['goodsimg0'];
                   var goodsname = data[$i]['goodsname'];
                   var goodsdepict = data[$i]['goodsdepict'];
                   var paytype = data[$i]['paytype'];
                   var paynum = data[$i]['paynum'];
                   var commentnum = data[$i]['commentnum'];
                   var zannum = data[$i]['zannum'];
                   var username = data[$i]['username'];
                   var userimg = 'http://localhost/jie/headimg/'+data[$i]['userimg'];
                   var day = data[$i]['day'];
                   var goodspath = 'http://localhost/jie/index.html/Goods/Index&gid='+goodsid;

                   var child = "<article><div class='img'><a href='"+goodspath+"'><img src='"+goodsimg0+"' width='280px' height='280px'></a></div>" +
                       " <div class='userandtime'> <a href='"+userid+"' class='head'><img src='"+userimg+"' width='45px' height='45px'></a>" +
                       " <span class='username'>"+username+"</span> <span class='timeout'>"+day+"</span> </div> <ul> " +
                       "<li><a href='javascript:void(0);'>"+paynum+"<i class='demo-icon icon-yen'>&#xe85b;</i></a></li> <li><a href='"+goodspath+"'><i class='demo-icon icon-basket-1'>&#xe858;</i>"+commentnum+"想要</a></li>" +
                       " <li><a href=''>"+zannum+"赞</a></li></ul><div class='godsmessage'><p class='goodsname'>"+goodsname+"</p>" +
                       "<p class='discript'>"+goodsdepict+"</p></div></article>";
                   $('#message').append(child);
               }
           }
           //没有更多后修改按钮样式
           if($num < 3){
               $("#more").css('color', 'red');
           }
       }, 'json');
   });
});
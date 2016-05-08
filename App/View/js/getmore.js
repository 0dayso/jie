/**
 * Created by Administrator on 2016/4/22.
 * 更多商品请求，异步加载模块
 *
 */

$(function () {
   $('#more').click(function () {
       var login = $('<i class="demo-icon icon-spin6 animate-spin">&#xe814;</i>');
       setTimeout(loginmore, 800);
       $('#more').css('opacity', '0');
       $('.animate-spin').css('opacity', '1');
       function loginmore() {
           $.post('http://localhost/jie/index.php/Show/More', null, function (data) {
               //总共的数据长度
               var $num = data.length;
               if($num > 0){
                   for(var $i = 0; $i < $num; $i++){
                       //获得单个货物信息
                       var goodsid = data[$i]['goodsid'];
                       var userid = 'http://localhost/jie/index.php/User/Index&userid='+data[$i]['userid'];
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
                       var goodspath = 'http://localhost/jie/index.php/Goods/Index&gid='+goodsid;

                       /* 判断类型  */
                       if(paynum == 0 || paytype== 0){
                           var str = '<i class="demo-icon icon-gift">&#xe869;</i>';
                       } else if(paytype == 1) {
                           var str =  paynum+'<i class="demo-icon icon-yen">&#xe86c;</i>';
                       } else {
                           var str = paynum+'<i class="demo-icon icon-database">&#xe86f;</i>';
                       }

                       var child = "<article><div class='img'><a href='"+goodspath+"'><img src='"+goodsimg0+"' width='280px' height='280px'></a></div>" +
                           " <div class='userandtime'> <a href='"+userid+"' class='head'><img src='"+userimg+"' width='45px' height='45px'></a>" +
                           " <span class='username'>"+username+"</span> <span class='timeout'>"+day+"天过期</span> </div> <ul> " +
                           "<li><a href='javascript:void(0);'>"+str+"</a></li> <li><a href='"+goodspath+"'>"+commentnum+"<i class='demo-icon icon-cart-plus'>&#xe84d;</i></a></li>" +
                           " <li><a href=''>"+zannum+"<i class='demo-icon icon-thumbs-up'>&#xe838;</i></a></li></ul><div class='godsmessage'><p class='goodsname'>"+goodsname+"</p>" +
                           "<p class='discript'>"+goodsdepict+"</p></div></article>";
                       $('#message').append(child);
                   }
                   $('.animate-spin').css('opacity', '0');
                   $('#more').css('opacity', '1');
               }
               //没有更多后修改按钮样式
               if($num < 3){
                   $('#morebox').html('没有更多了').css({'font-size': '.9','color': '#afa'});
               }
           }, 'json');
       }
   });
});
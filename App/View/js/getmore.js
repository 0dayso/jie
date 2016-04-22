/**
 * Created by Administrator on 2016/4/22.
 * 更多商品请求，异步加载模块
 *
 */

$(function () {
   $('#more').click(function () {
       $.post('http://localhost/jie/index.php/ShowGoods/GetMore', null, function (data) {
            alert(data);
       });
   });
});
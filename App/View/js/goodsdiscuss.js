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
        if(flag == true){
            //用ajax向远程提交评论数据
            $.post('http://localhost/jie/index.php/Goods/PushDis',{"gdcontent": cont},function (data) {
                if(data != '0'){
                    alert(data);
                    $('#entermessage').html('评论失败');
                }else{
                    $('#entersend').val('');
                    //向评论显示中添加显示
                    console.log(cont);
                }
            });
        }
        return false;
    });


    $('#discuss').click(function () {
        
    });
});

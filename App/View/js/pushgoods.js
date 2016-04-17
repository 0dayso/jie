/**
 * Created by Administrator on 2016/4/17.
 */
$(function () {
    /* 名称字数监听 */
    $('#goodsname').keyup(function () {
        var goodsname = $(this).val();
        var len = goodsname.length;
        if(len>12){
            $('#gnamemessage').html('名称超过12字符').css({"color":"red","font-size":".84em"});
        }else{
            $('#gnamemessage').html('&nbsp;');
        }
    });

    /* 描述字符监听 */
    $('#goodsdis').keyup(function () {
        var goodsdis = $(this).val();
        var len = goodsdis.length;
        if(len > 76){
            $('#gdmessage').html('描述超过76字符').css({"color":"red","font-size":".84em"});
        }else {
            $('#gdmessage').html('&nbsp;');
        }
    });
});


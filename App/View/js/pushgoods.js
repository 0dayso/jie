/**
 * Created by Administrator on 2016/4/17.
 */
$(function () {
    /* 名称字数监听 */
    $('#goodsname').keyup(function () {
        var goodsname = $(this).val();
        goodsname = goodsname.replace(/(^\s*)|(\s*$)/g,'');
        var len = goodsname.length;
        if(len>12){
            $('#gnamemessage').html('名称超过12字符').css({"color":"red","font-size":".84em"});
        }else{
            $('#gnamemessage').html('&nbsp;');
        }
    });

    /*使用ajax,异步上传名称*/
    $('#goodsname').blur(function () {
        var goodsname = $(this).val();
        goodsname = goodsname.replace(/(^\s*)|(\s*$)/g,'');
        var len = goodsname.length;
        if(len < 12){
            $.post('http://localhost/jie/index.php/PushGoods/PushName',{"goodsname":goodsname},function (data) {
                $('#gnamemessage').html(data);
            });
        }else{
            $('#gnamemessage').html('名称超过12字符').css({"color":"red","font-size":".84em"});
        }
    });

    /* 描述字符监听 */
    $('#goodsdis').keyup(function () {
        var goodsdis = $(this).val();
        goodsdis = goodsdis.replace(/(^\s*)|(\s*$)/g,'');
        var len = goodsdis.length;
        if(len > 76){
            $('#gdmessage').html('描述超过76字符').css({"color":"red","font-size":".84em"});
        }else {
            $('#gdmessage').html('&nbsp;');
        }
    });

    /* 使用ajax异步上传描述 */
    $('#goodsdis').blur(function () {
        var goodsdepict = $(this).val();
        goodsdepict = goodsdepict.replace(/(^\s*)|(\s*$)/g,'');
        var len = goodsdepict.length;
        if(len < 76){
            $.post('http://localhost/jie/index.php/PushGoods/PushgDepict',{"goodsdepict":goodsdepict},function (data) {
                $('#gdmessage').html(data);
            });
        }else{
            $('#gdmessage').html('名称超过12字符').css({"color":"red","font-size":".84em"});
        }
    });

    /* 各种类型对应价格 */
    $('input[type = radio]').on('click', function () {
        var value = $(this).val();
        var str = "";
        switch (parseInt(value)){
            case 0:
                str = '<div><span>感谢您为社区带来的免费分享！</span><input class="num" name="money" type="hidden" value="0" /></div>';
                break;
            case 1:
                str = '<div><span>支付</span><input id="num" class="num"  name="money" type="text" placeholder="输入所需价格，如39.39"/><span>￥</span></div>';
                break;
            case 2:
                str = '<div><span>支付</span><input class="num"  name="money" type="text" placeholder="输入整数积分，如39"/></div>';
                break;
        }
        $('#typeactive').html(str);
    });

    /* 使用异步上传要的价格和已经选中的类型 */
    $("body").delegate(".num","click change",function(e){
        if(e.type=="click"){

        }else if(e.type=="change"){
            //获得售卖的类型
            paytype = $('input[type=radio]:checked').val();
            //获得数据,并判断类型
            var numvalue = $(this).val();
            numvalue = numvalue.replace(/(^\s*)|(\s*$)/g,'');
            var par1 = /^[0-9]{1,5}(.[0-9]{1,3})?$/;
            var par2 = /^[0-9]{1,5}$/;
            if(parseInt(paytype) == 1 && par1.test(numvalue)){
                $.post('http://localhost/jie/index.php/PushGoods/PayNum', {"paynum":numvalue,"paytype":paytype}, function (data) {
                    alert(data);
                });
            }else if(parseInt(paytype) == 2 && par2.test(numvalue)){
                $.post('http://localhost/jie/index.php/PushGoods/PayNum', {"paynum":numvalue,"paytype":paytype}, function (data) {
                    alert(data);
                });
            }else{
                alert('请按提示输入');
            }
        }
    });

    /* 点击添加图片,并形成缩略图 */
    $(".file").on("change", function(){
        /*files得到一个文件对像*/
        var files = !!this.files ? this.files : [];
        /* 限制一定是图像 */
        if (!files.length || !window.FileReader) return;
        var divparent = $(this).parent();

        /**/
        if (/^image/.test( files[0].type)){
            /*Read the local file as a DataURL*/
            var reader = new FileReader();
            /*When loaded, set image data as background of div*/
            reader.readAsDataURL(files[0]);
            reader.onloadend = function(){
                divparent.css("background-image", "url("+this.result+")");
                divparent.children('span').html('更换图片').css('color', '#cc44aa');
            }
        }
    });


});


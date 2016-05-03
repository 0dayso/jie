/**
 * Created by Administrator on 2016/4/17.
 */
var nameflag = false;
var disflag = false;
var typeflag = true;
var imgflag = false;

/* 检查商品发布所有操作都已经成功 */
function flagTrue() {
    if(nameflag == true && disflag == true && typeflag == true && imgflag == true){
        $('.submit').css({'background-color':'#ec5252','cursor':'pointer'});
        return true;
    }else{
        $('.submit').css({'background-color':'#ccc','cursor':'auto'});
        return false;
    }
}

$(function () {
    /* 名称字数监听 */
    $('#goodsname').keyup(function () {
        var goodsname = $(this).val();
        goodsname = goodsname.replace(/(^\s*)|(\s*$)/g,'');
        var len = goodsname.length;
        if(len>12){
            $('#gnamemessage').html('不能超过12字符');
            nameflag = false;
        }else if(len =0 ){
            $('#gnamemessage').html('不能为空');
            nameflag = false;
        }else{
            $('#gnamemessage').html('&nbsp;');
        }
    });

    /*使用ajax,异步上传名称*/
    $('#goodsname').blur(function () {
        var goodsname = $(this).val();
        goodsname = goodsname.replace(/(^\s*)|(\s*$)/g,'');
        var len = goodsname.length;
        if(len < 12 && len != 0){
            $.post('http://localhost/jie/index.php/PushGoods/PushName',{"goodsname":goodsname},function (data) {
                $('#gnamemessage').html(data);
                nameflag = true;
                flagTrue();
            });
        }else if(len == 0){
            $('#gnamemessage').html('请输入名称');
            nameflag = false;
        }else{
            $('#gnamemessage').html('不能超过12字符');
            nameflag = false;
        }
    });


    /* 描述字符监听 */
    $('#goodsdis').keyup(function () {
        var goodsdis = $(this).val();
        goodsdis = goodsdis.replace(/(^\s*)|(\s*$)/g,'');
        var len = goodsdis.length;
        if(len > 110){
            $('#gdmessage').html('超过110字符');
            disflag = false;
        }else if(len < 6){
            $('#gdmessage').html('描述太少了');
            disflag = false;
        }else {
            $('#gdmessage').html('&nbsp;');
        }
    });

    /* 使用ajax异步上传描述 */
    $('#goodsdis').blur(function () {
        var goodsdepict = $(this).val();
        goodsdepict = goodsdepict.replace(/(^\s*)|(\s*$)/g,'');
        var len = goodsdepict.length;
        if(len >= 6 && len <= 110){
            $.post('http://localhost/jie/index.php/PushGoods/PushgDepict',{"goodsdepict":goodsdepict},function (data) {
                $('#gdmessage').html(data);
                disflag = true;
                flagTrue();
            });
        }else if(len < 6){
            $('#gdmessage').html('描述太少了');
            disflag = false;
        }else{
            $('#gdmessage').html('超过110字符');
            disflag = false;
        }
    });


    /* 各种类型对应价格 */
    $('input[type = radio]').on('click', function () {
        typeflag = false;
        flagTrue();
        var value = $(this).val();
        var str = "";
        switch (parseInt(value)){
            case 0:
                typeflag = true;
                flagTrue();
                str = '<div class="typebox"><span>感谢您为社区带来的免费分享！</span><input class="num" name="money" type="hidden" value="0" /><span class="errormess" id="payerror"></span></div>';
                break;
            case 1:
                str = '<div class="typebox"><span>对方支付人民币</span><input id="num" class="num"  name="money" type="text" placeholder="价格如39.39￥"/><span><i class="demo-icon icon-yen">&#xe86c;</i></span><span class="errormess" id="payerror"></span></div>';
                break;
            case 2:
                str = '<div class="typebox"><span>对方支付积分</span><input class="num"  name="money" type="text" placeholder="积分如39"/><span><i class="demo-icon icon-database">&#xe86f;</i></span><span class="errormess" id="payerror"></span></div>';
                break;
        }
        $('#typeactive').html(str);
    });

    /* 使用异步上传要的价格和已经选中的类型 */
    $("body").delegate(".num","click change",function(e){
        typeflag = false;
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
                    typeflag = true;
                    flagTrue();
                    $("#payerror").html(data);
                });
            }else if(parseInt(paytype) == 2 && par2.test(numvalue)){
                $.post('http://localhost/jie/index.php/PushGoods/PayNum', {"paynum":numvalue,"paytype":paytype}, function (data) {
                    typeflag = true;
                    flagTrue();
                    $("#payerror").html(data);
                });
            }else{
                $("#payerror").html('请按提示输入');
            }
        }
    });

    var num = 1;

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
        imgflag = true;
        flagTrue();

        switch (num){
            case 1:
                $('#box1').css('visibility', 'visible');
                num++;
                break;
            case 2:
                $('#box2').css('visibility', 'visible');
                num++;
                break;
            case 3:
                $('#box3').css('visibility', 'visible');
                num++;
                break;
        }

        /*$(this).next().css('display', 'block');*/

    });


    /* 提交操作 */
    $('.addgoods').submit(function () {
        if(flagTrue()){
            return true;
        }else{
            return false;
        }
    });
});


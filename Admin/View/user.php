<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link href="http://localhost/jie/Admin/View/style/base.css" rel="stylesheet" type="text/css"/>
    <link href="http://localhost/jie/Admin/View/style/user.css" rel="stylesheet" type="text/css"/>
    <script src="http://localhost/jie/Admin/View/js/jquery1.12.1.js"></script>
</head>
<body>
    <table>
        <tr>
            <th>用户id</th>
            <th>用户名</th>
            <th>头像</th>
            <th>邮箱</th>
            <th>QQ号</th>
            <th>地址</th>
            <th>电话</th>
            <th>积分</th>
            <th>操作</th>
        </tr>
        <tbody id="box">
        <?php 
        if(!empty($data)){
            foreach ($data as $value){
                $userid = empty($value['userid'])?"":$value['userid'];
                $username = empty($value['username'])?"":$value['username'];
                $userimg = empty($value['userimg'])?"":$value['userimg'];
                $userimg = INLET.'headimg/'.$userimg;
                $email = empty($value['email'])?"":$value['email'];
                $qq = empty($value['qq'])?"":$value['qq'];
                $address = empty($value['address'])?"":$value['address'];
                $tel = empty($value['tel'])?"":$value['tel'];
                $point = empty($value['point'])?"":$value['point'];
                if($value['userlock']==0){
                    $lock = "锁定";
                    $lockurl = "http://localhost/jie/admin.php/TubeUser/UserTube&userid=".$userid.'&action=lock';
                }else{
                    $lockurl = "http://localhost/jie/admin.php/TubeUser/UserTube&userid=".$userid.'&action=unlock';
                    $lock = "解锁";
                }
                $del = "http://localhost/jie/admin.php/TubeUser/UserTube&userid=".$userid.'&action=del';
                echo "<tr>
                        <td>{$userid}</td>
                        <td>{$username}</td>
                        <td><img src='{$userimg}' width='45px' height='45px' /></td>
                        <td>{$email}</td>
                        <td>{$qq}</td>
                        <td>{$address}</td>
                        <td>{$tel}</td>
                        <td>{$point}</td>
                        <td><a href='{$del}'>删除</a>/<a href='{$lockurl}'>{$lock}</a></td>
                       </tr>";
            }
        }
        ?>
        </tbody>
    </table>
    <?php 
        if($count >= 1){
            echo "<div class='bar'><button id='pre'>上一页</button><button id='nex'>下一页</button></div>";
        }
    ?>
</body>
<script>
    $(function () {
        $("#pre").click(function () {
            $.post('http://localhost/jie/admin.php/TubeUser/PreUser','',function (data) {
                if(data != '' && data != undefined && data != null){
                    var len = data.length;
                    var str = '';
                    for(var i = 0; i < len; i++){
                        var userid = data[i]['userid'];
                        var address = data[i]['address'];
                        var email = data[i]['email'];
                        var point = data[i]['point'];
                        var qq = data[i]['qq'];
                        var tel = data[i]['tel'];
                        var username = data[i]['username'];
                        var userimg = 'http://localhost/jie/headimg/'+data[i]['userimg'];

                        //判断锁定还是解锁
                        if(data[i]['userlock'] == 0){
                            var lock = '锁定';
                            var lockurl = "http://localhost/jie/admin.php/TubeUser/UserTube&userid="+data[i]['userid']+'&action=lock';
                        } else {
                            var lock = "解锁";
                            var lockurl = "http://localhost/jie/admin.php/TubeUser/UserTube&userid="+data[i]['userid']+'&action=unlock';
                        }

                        //给定删除链接
                        var del = "http://localhost/jie/admin.php/TubeUser/UserTube&userid="+data[i]['userid']+'&action=del';

                        str += "<tr><td>"+userid+"</td><td>"+username+"</td><td><img src='"+userimg+"' width='45px' height='45px' /></td><td>"+email+"</td><td>"+qq+"</td><td>"+address+"</td><td>"+tel+"</td><td>"+point+"</td><td><a href='"+del+"'>删除</a>/<a href='"+lockurl+"'>"+lock+"</a></td></tr>";
                    }
                    $('#box').html(str);
                }
            },"json");
        });
        $('#nex').click(function () {
            $.post('http://localhost/jie/admin.php/TubeUser/NexUser','',function (data) {
                if(data != '' && data != undefined && data != null){
                    var len = data.length;
                    var str = '';
                    for(var i = 0; i < len; i++){
                        var userid = data[i]['userid'];
                        var address = data[i]['address'];
                        var email = data[i]['email'];
                        var point = data[i]['point'];
                        var qq = data[i]['qq'];
                        var tel = data[i]['tel'];
                        var username = data[i]['username'];
                        var userimg = 'http://localhost/jie/headimg/'+data[i]['userimg'];
                        //判断锁定还是解锁
                        if(data[i]['userlock'] == 0){
                            var lock = '锁定';
                            var lockurl = "http://localhost/jie/admin.php/TubeUser/UserTube&userid="+data[i]['userid']+'&action=lock';
                        } else {
                            var lock = "解锁";
                            var lockurl = "http://localhost/jie/admin.php/TubeUser/UserTube&userid="+data[i]['userid']+'&action=unlock';
                        }

                        //给定删除链接
                        var del = "http://localhost/jie/admin.php/TubeUser/UserTube&userid="+data[i]['userid']+'&action=del';

                        str += "<tr><td>"+userid+"</td><td>"+username+"</td><td><img src='"+userimg+"' width='45px' height='45px' /></td><td>"+email+"</td><td>"+qq+"</td><td>"+address+"</td><td>"+tel+"</td><td>"+point+"</td><td><a href='"+del+"'>删除</a>/<a href='"+lockurl+"'>"+lock+"</a></td></tr>";
                    }
                    $('#box').html(str);
                }
            },'json');
        });
    })
</script>
</html>
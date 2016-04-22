<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>接下去，晒出你的旧物</title>
    <script src="<?php echo INLET;?>App/View/js/jquery1.12.1.js"></script>
    <link href="<?php echo INLET;?>App/View/style/index.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <section class="page">
        <!-- 页面头 -->
        <header class="header">
            <nav>
                <li><h1 class="logo"><span>接</span>下去</h1></li>
                <li><a href="<?php echo INLET;?>index.php">首页</a></li>
                <li><a href="<?php echo INLET;?>index.php/ShowGoods/GetFree">免费物品</a></li>
                <li><a href="<?php echo INLET;?>index.php/ShowGoods/GetPay">付费物品</a></li>
                <li><a href="#" target="_blank">全站信息</a></li>
                <li>
                    <form class="search">
                        <input type="search" placeholder="搜索在这里" name="search" class="search"/>
                        <input type="submit" value="搜索" class="searchbottom">
                    </form>
                </li>
                <li>
                <?php 
                    if(empty($_SESSION['user']['userid'])){
                       echo '<button class="register" id="register">注&nbsp;册</button>&nbsp;&nbsp;&nbsp;
                        <button class="login" id="login">登&nbsp;录</button>';
                    }else{
                        $username = $_SESSION['user']['username'];
                        $userhead = $_SESSION['user']['userimg'];
                        $userhead = INLET.'headimg/'.$userhead;
                        echo "<ul class='lastbar'>
                            <li><a href='#' ><img src='{$userhead}' width='45px' height='45px'></a></li>
                            <li><a href='#'>{$username}</a></li>
                            <li><a href='#'>消息</a></li>
                            <li class='out'><a href='".INLET."index.php/index/LogOut'>退出</a></li>
                            </ul>";
                    } 
                ?>        
                </li>
            </nav>
        </header>
        <article class="content">
            <section class="message">
                <?php 
                    $goodsbox->rewind();
                    while ($goodsbox->TheValue()){
                        //获得单个货物信息
                        $oneGoods = $goodsbox->current();
/*                         var_dump($oneGoods); */
                        $goodsid = $oneGoods['goodsid'];                        
                        $userid = $oneGoods['userid'];
                        $goodsimg0 = INLET.'goodsimg/'.$oneGoods['goodsimg0'];
                        $goodsname = $oneGoods['goodsname'];
                        $goodsdepict = $oneGoods['goodsdepict'];
                        $paytype = $oneGoods['paytype'];
                        $paynum = $oneGoods['paynum'];
                        $commentnum = $oneGoods['commentnum'];
                        $zannum = $oneGoods['zannum'];
                        $username = $oneGoods['username'];
                        $userimg = INLET.'headimg/'.$oneGoods['userimg'];
                        $day = $oneGoods['day'];
                        
                        
                        echo "<article>
                            <div class='img'><img src='{$goodsimg0}' width='280px' height='280px'></div>
                            <div class='userandtime'>
                            <a href='' class='head'><img src='{$userimg}' width='45px' height='45px'></a>
                            <span class='username'>{$username}</span>
                            <span class='timeout'>{$day}</span>
                            </div>
                            <ul>
                            <li><a href='javascript:void(0);'>{$paynum}元</a></li>
                            <li><a href='#'>{$commentnum}想要</a></li>
                            <li><a href=''>{$zannum}赞</a></li>
                            </ul>
                            <div class='godsmessage'>
                            <p class='goodsname'>{$goodsname}</p>
                            <p class='discript'>{$goodsdepict}</p>
                            </div>
                            </article>";
                        $goodsbox->next();
                    }
                ?>


            </section>
            <!-- 发布和信息 -->
            <section class="blown">
                <h2>发布旧物</h2>
                <form class="addgoods" action="<?php echo INLET;?>index.php/PushGoods/SubmitFile" method="post" enctype="multipart/form-data">
                    <label for="goodsname">
                        <input name="goodsname" id="goodsname" class="goodsname" placeholder="请输入旧物名,最多12字"/>
                        <span id="gnamemessage">&nbsp;</span>
                    </label>
                    <label for="goodsdis">
                        <textarea class="goodsdis" id="goodsdis" name="goodsdis" placeholder="输入对旧物的描述,最多76字符"></textarea>
                        <span id="gdmessage">&nbsp;</span>
                    </label>
                    <div id="imgbox">
                        <input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>
                        <div><input type="file" class="file" name="file[]"/><span>上传图片</span></div>
                        <div><input type="file" class="file" name="file[]"/><span>上传图片</span></div>
                        <div><input type="file" class="file" name="file[]"/><span>上传图片</span></div>
                        <div><input type="file" class="file" name="file[]"/><span>上传图片</span></div>
                    </div>
                    <div class="type">
                        <label for="free" class="rad"><input class="select" type="radio" name="type" value="0" checked id="free"><span>免费</span></label>
                        <label for="rmb" class="rad"><input class="select" type="radio" name="type" value="1" id="rmb"/><span>人民币</span></label>
                        <label for="num" class="rad"><input class="select" type="radio" name="type" value="2" id="num"/><span>积分</span></label>
                    </div>
                    <div id="typeactive" class="typeactive">
                        <div><span>感谢您为社区带来的免费分享！</span></div>
                    </div>
                    <input type="submit" name="submit" class="submit" value="发&nbsp;布"/>
                </form>
            </section>
        </article>
        <!-- 页面脚 -->
        <footer class="footer">
            <article class="more"><div><button>加载更多</button></div></article>
            <article class="authormessage">
                <p><span>辛丙亮&nbsp;&nbsp;出品;</span>&nbsp;&nbsp;Tel:15102724518;&nbsp;&nbsp;QQ:709464835</p>
                <p>全站代码开放,代码托管地址(GitHub)&nbsp;&nbsp;<a href="https://github.com/xinbingliang/jie" target="_blank">接下去</a>&nbsp;&nbsp;;期待更多人加入！</p>
            </article>
        </footer>
        <section class="outface loginform">
            <h2>登&nbsp;&nbsp;录</h2><a href="javascript:void(0);" id="closelogin">关闭</a>
            <form action="<?php echo INLET;?>index.php/index/Log" method="post">
                <label for="lemail"><input type="text" id="lemail" name="email" placeholder="请输入您的邮箱"/><br/><span id="lemailmessage">&nbsp;&nbsp;</span></label>
                <label for="password"><input type="password" id="lpassword" name="password" placeholder="请输入您的密码"><br/><span id="lpasswordMessage">&nbsp;&nbsp;</span></label>
                <input class="loginsubmit" type="submit" value="登&nbsp;&nbsp;&nbsp;录"/>
            </form>
        </section>
        <section class="outface registerform">
            <h2>注&nbsp;&nbsp;册</h2><a href="javascript:void(0);" id="closeregister">关闭</a>
            <form action="<?php echo INLET;?>index.php/index/Reg" method="post">
                <label for="idcard"><input type="text" id="idcard" name="idcard" placeholder="请输入身份证号"/><br/><span id="idcardmessage">&nbsp;&nbsp;</span></label>
                <label for="username"><input type="text" id="username" name="username" placeholder="请输入真实姓名"/><br/><span id="namemessage">&nbsp;&nbsp;</span></label>
                <label for="email"><input type="text" id="email" name="email" placeholder="请输入您的邮箱"><br/><span id="emailmessage">&nbsp;&nbsp;</span></label>
                <label for="password" class="passwordlast"><input type="password" id="password" name="password" placeholder="请输入您的密码"><br/><span id="passwordmessage">&nbsp;&nbsp;</span></label>
                <input class="rigistersubmit" type="submit" value="登&nbsp;&nbsp;&nbsp;录"/>
            </form>
        </section>
<!--        <section class="hover">
            <a href="#">回到顶部</a>
            <a>BUG报告</a>
        </section>-->
    </section>
</body>
<!--自己编写的-->
<script src="<?php echo INLET;?>App/View/js/outface.js"></script>
<script src="<?php echo INLET;?>App/View/js/pushgoods.js"></script>
</html>
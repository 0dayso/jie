<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>接下去</title>
    <script src="<?php echo INLET;?>App/View/js/jquery1.12.1.js"></script>
    <link href="<?php echo INLET;?>App/View/style/index.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <section class="page">
        <!-- 页面头 -->
        <header class="header">
            <nav>
                <li><h1 class="logo"><span>接</span>下去</h1></li>
                <li><a href="#">首页</a></li>
                <li><a href="#">免费物品</a></li>
                <li><a href="#">付费物品</a></li>
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
                        echo "<ul class='lastbar'>
                            <li><a href='#'>&nbsp;&nbsp;</a></li>
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
                <article>
                    <div class="img"></div>
                    <div class="bar">
                        <ul>
                            <li>用户头像</li>
                            <li>辛丙亮</li>
                        </ul>
                        <ul>
                            <li>想要</li>
                            <li>赞</li>
                        </ul>
                    </div>
                    <div class="godsmessage">
                        <p class="goodsname">物品名称</p>
                        <p class="discript">
                            描述信息
                        </p>
                    </div>
                </article>
                <article>
                    <div class="img"></div>
                    <div class="bar">
                        <ul>
                            <li>用户头像</li>
                            <li>辛丙亮</li>
                        </ul>
                        <ul>
                            <li>想要</li>
                            <li>赞</li>
                        </ul>
                    </div>
                    <div class="godsmessage">
                        <p class="goodsname">物品名称</p>
                        <p class="discript">
                            描述信息
                        </p>
                    </div>
                </article>
                <article>
                    <div class="img"></div>
                    <div class="bar">
                        <ul>
                            <li>用户头像</li>
                            <li>辛丙亮</li>
                        </ul>
                        <ul>
                            <li>想要</li>
                            <li>赞</li>
                        </ul>
                    </div>
                    <div class="godsmessage">
                        <p class="goodsname">物品名称</p>
                        <p class="discript">
                            描述信息
                        </p>
                    </div>
                </article>
                <article>
                    <div class="img"></div>
                    <div class="bar">
                        <ul>
                            <li>用户头像</li>
                            <li>辛丙亮</li>
                        </ul>
                        <ul>
                            <li>想要</li>
                            <li>赞</li>
                        </ul>
                    </div>
                    <div class="godsmessage">
                        <p class="goodsname">物品名称</p>
                        <p class="discript">
                            描述信息
                        </p>
                    </div>
                </article>
                <article>
                    <div class="img"></div>
                    <div class="bar">
                        <ul>
                            <li>用户头像</li>
                            <li>辛丙亮</li>
                        </ul>
                        <ul>
                            <li>想要</li>
                            <li>赞</li>
                        </ul>
                    </div>
                    <div class="godsmessage">
                        <p class="goodsname">物品名称</p>
                        <p class="discript">
                            描述信息
                        </p>
                    </div>
                </article>
                <article>
                    <div class="img"></div>
                    <div class="bar">
                        <ul>
                            <li>用户头像</li>
                            <li>辛丙亮</li>
                        </ul>
                        <ul>
                            <li>想要</li>
                            <li>赞</li>
                        </ul>
                    </div>
                    <div class="godsmessage">
                        <p class="goodsname">物品名称</p>
                        <p class="discript">
                            描述信息
                        </p>
                    </div>
                </article>
                <article>
                    <div class="img"></div>
                    <div class="bar">
                        <ul>
                            <li>用户头像</li>
                            <li>辛丙亮</li>
                        </ul>
                        <ul>
                            <li>想要</li>
                            <li>赞</li>
                        </ul>
                    </div>
                    <div class="godsmessage">
                        <p class="goodsname">物品名称</p>
                        <p class="discript">
                            描述信息
                        </p>
                    </div>
                </article>
                <article>
                    <div class="img"></div>
                    <div class="bar">
                        <ul>
                            <li>用户头像</li>
                            <li>辛丙亮</li>
                        </ul>
                        <ul>
                            <li>想要</li>
                            <li>赞</li>
                        </ul>
                    </div>
                    <div class="godsmessage">
                        <p class="goodsname">物品名称</p>
                        <p class="discript">
                            描述信息
                        </p>
                    </div>
                </article>
                <article>
                    <div class="img"></div>
                    <div class="bar">
                        <ul>
                            <li>用户头像</li>
                            <li>辛丙亮</li>
                        </ul>
                        <ul>
                            <li>想要</li>
                            <li>赞</li>
                        </ul>
                    </div>
                    <div class="godsmessage">
                        <p class="goodsname">名称</p>
                        <p class="discript">
                            描述信息
                        </p>
                    </div>
                </article>
            </section>
            <!-- 发布和信息 -->
            <section class="blown">
                <h2>发布旧物</h2>
                <form class="addgoods" action="" method="post">
                    <label for="goodsname">
                        <input name="goodsname" id="goodsname" class="goodsname" placeholder="请输入旧物名,最多12字"/>
                    </label>
                    <label for="goodsdis">
                        <textarea class="goodsdis" id="goodsdis" name="goodsdis" placeholder="输入对旧物的描述,最多76字符"></textarea>
                    </label>
                    <label>
                        <h3>最多添加4张图片</h3>
                        <input type="file" name="goodsimg[]"/>
                        <input type="file" name="goodsimg[]"/>
                        <input type="file" name="goodsimg[]"/>
                        <input type="file" name="goodsimg[]"/>
                    </label>
                    <label>
                        <div><input type="radio" name="type" value="1"><span>免费分享</span></div>
                        <div><input type="radio" name="type" value="2"/><span>付费购买</span></div>
                        <div><input type="radio" name="type" value="3"/><span>积分购买</span></div>
                    </label>
                    <div class="typeactive">
                        <div><span>价格</span><input name="money" type="" placeholder="输入您的价格"/><span>￥</span></div>
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
        <section class="hover">
            <a href="#">回到顶部</a>
            <a>BUG报告</a>
        </section>
    </section>
</body>
<script src="<?php echo INLET;?>App/View/js/outface.js"></script>
</html>
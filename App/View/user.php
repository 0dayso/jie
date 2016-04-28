<article class="content">
    <!-- 用户信息和评价 -->
    <section class="message">
        <!-- 资料 -->
        <article class="usermessage">
            <div class="head">
                <img src="http://localhost/jie/headimg/<?php echo $userData['userimg']?>" width="80px" height="80px">
                <button class="imgbutton">换头像</button>
            </div>
            <label class="username">
                <span class="type">姓名:&nbsp;&nbsp;</span><span class="value namevalue"><?php echo $userData['username']?></span>
            </label>
            <label class="userbrith">
                <span class="type">出生年:&nbsp;&nbsp;</span><span class="value brithyear"><?php echo $userData['birthday']?></span>
            </label>
            <label class="sex">
                <span class="type">性别:&nbsp;&nbsp;</span><span class="value namevalue"><?php echo $userData['gender']?></span>
            </label>
            <label class="注册时间">
                <span class="type">注册时间:&nbsp;&nbsp;</span><span class="value registertime"></span>
            </label>
            <label>
                <span class="type">QQ:&nbsp;&nbsp;</span><span class="value namevalue"><?php echo $userData['qq']?></span>
                <a id="cqq">修改</a>
            </label>
            <label>
                <span class="type">地址:&nbsp;&nbsp;</span><span class="value address"><?php echo $userData['address']?></span><!-- <input type="text" class="address" id="address"/> -->
                <a href="javascript:void(0);" id="cadd">修改</a>
            </label>
            <label>
                <span class="type">邮箱:&nbsp;&nbsp;</span><span class="value email"><?php echo $userData['email']?></span><!-- <input type="text" class="email" id="email"/> -->
                <a href="javascript:void(0);" id="cemail">修改</a>
            </label>
            <label>
                <span class="type">电话:&nbsp;&nbsp;</span><span class="value tel"><?php echo $userData['tel']?></span><!-- <input type="text" class="tel" id="tel"/> -->
                <a href="javascript:void(0);" id="ctel">修改</a>
            </label>
            <div class="changepassword">
                <p id="passwordbox">
                    <label><span>旧密码:&nbsp;&nbsp;</span><input id="oldpassword" type="password" name="oldpassword" placeholder="输入原来密码"/>
                        <span id="oldpass">&nbsp;</span>
                    </label>
                    <label><span>新密码:&nbsp;&nbsp;</span><input id="newpassword" type="password" name="newpassword" placeholder="输入新的密码"/>
                        <span id="newpass">&nbsp;</span>
                    </label>
                </p>
                <button id="passwordbutton">修改密码</button>
            </div>
            <label class="integrallabel"><span class="point">1200</span>积分<span class="integral">=</span><span>100</span>元<button>提现到支付宝</button></label>
        </article>
        <!-- 对用户评价 -->
        <section class="userevaluate">
            <div>
            <div id="userdis">
                <p>
                    <i class="demo-icon icon-star-empty start">&#xe812;</i>
                    <i class="demo-icon icon-star-empty start">&#xe812;</i>
                    <i class="demo-icon icon-star-empty start">&#xe812;</i>
                    <i class="demo-icon icon-star-empty start">&#xe812;</i>
                    <i class="demo-icon icon-star-empty start">&#xe812;</i>
                </p>
                <textarea placeholder="请输入您对该用户评价,最多120个字符" id="disusertext"></textarea>
                <button id="userdisub">提交</button>
            </div>
            </div>
            <?php
				/*var_dump($disdata);	*/
				foreach($disdata as $value){
                    $start = '';
                    for($i=0; $i < $value['start']; $i++){
                        $start .= '<i class="demo-icon icon-star">&#xe811;</i>';
                    }
                    echo "<article class='valuate'>
                                <p>{$value['udcontent']}&nbsp;&nbsp;&nbsp;&nbsp;{$start}</p>
                                <div><span class='udtime'>{$value['udtime']}</span><span class='user'>{$value['username']}</span></div>
                    </article>";
				}
			?>
                        <!--<article class="valuate">
                            <p>评价(不大于120字符)&nbsp;&nbsp;&nbsp;&nbsp;<span class="start">3星</span></p>
                            <div><span>2015.4.5</span><span class="user">用户名 </span></div>
                        </article>
                        <article class="valuate">
                            <p>评价(不大于120字符)&nbsp;&nbsp;&nbsp;&nbsp;<span class="start">3星</span></p>
                            <div><span>2015.4.5</span><span class="user">用户名 </span></div>
                        </article>
                        <article class="valuate">
                            <p>评价(不大于120字符)&nbsp;&nbsp;&nbsp;&nbsp;<span class="start">3星</span></p>
                            <div><span>2015.4.5</span><span class="user">用户名 </span></div>
                        </article>
                        <article class="valuate">
                            <p>评价(不大于120字符)&nbsp;&nbsp;&nbsp;&nbsp;<span class="start">3星</span></p>
                            <div><span>2015.4.5</span><span class="user">用户名 </span></div>
                        </article>-->
                    </section>
    </section>
    <!-- 历史记录 -->
    <section class="blown">
                <article class="goods">
                    <img src="http://localhost/jie/goodsimg/3_0_160421093035_634.jpg" width="280px" height="280px">
                    <div class="bar">
                        <ul>
                            <li>111想要</li>
                            <li>100赞</li>
                            <li>3天过期</li>
                        </ul>
                    </div>
                    <div class="godsmessage">
                        <p class="goodsname"><span>品名&nbsp;</span></p>
                        <p><span>类别&nbsp;</span></p>
                        <p class="discript"><span>描述信息&nbsp;</span>这些是描述信息,这些是描述信息,这些是描述信息,
                            这些是描述信息,这些是描述信息,</p>
                    </div>
                    <button>修改</button>
                </article>
                <article class="goods">
                    <img src="http://localhost/jie/goodsimg/3_0_160421093035_634.jpg" width="280px" height="280px">
                    <div class="bar">
                        <ul>
                            <li>111想要</li>
                            <li>100赞</li>
                            <li>3天到期</li>
                        </ul>
                    </div>
                    <div class="godsmessage">
                        <p class="goodsname"><span>品名&nbsp;</span></p>
                        <p><span>类别&nbsp;</span></p>
                        <p class="discript"><span>描述信息&nbsp;</span></p>
                    </div>
                    <button>修改</button>
                </article>
                <article class="goods">
                    <img src="http://localhost/jie/goodsimg/3_0_160421093035_634.jpg" width="280px" height="280px">
                    <div class="bar">
                        <ul>
                            <li>111想要</li>
                            <li>100赞</li>
                            <li>3天到期</li>
                        </ul>
                    </div>
                    <div class="godsmessage">
                        <p class="goodsname"><span>品名&nbsp;</span></p>
                        <p><span>类别&nbsp;</span></p>
                        <p class="discript"><span>描述信息&nbsp;</span></p>
                    </div>
                    <button>修改</button>
                </article>
                <article class="goods">
                    <img src="http://localhost/jie/goodsimg/3_0_160421093035_634.jpg" width="280px" height="280px">
                    <div class="bar">
                        <ul>
                            <li>111想要</li>
                            <li>100赞</li>
                            <li>3天到期</li>
                        </ul>
                    </div>
                    <div class="godsmessage">
                        <p class="goodsname"><span>品名&nbsp;</span></p>
                        <p><span>类别&nbsp;</span></p>
                        <p class="discript"><span>描述信息&nbsp;</span></p>
                    </div>
                    <button>修改</button>
                </article>
                <article class="goods">
                    <img src="http://localhost/jie/goodsimg/3_0_160421093035_634.jpg" width="280px" height="280px">
                    <div class="bar">
                        <ul>
                            <li>111想要</li>
                            <li>100赞</li>
                            <li>3天到期</li>
                        </ul>
                    </div>
                    <div class="godsmessage">
                        <p class="goodsname"><span>品名&nbsp;</span></p>
                        <p><span>类别&nbsp;</span></p>
                        <p class="discript"><span>描述信息&nbsp;</span></p>
                    </div>
                    <button>修改</button>
                </article>
                <article class="goods">
                    <img src="http://localhost/jie/goodsimg/3_0_160421093035_634.jpg" width="280px" height="280px">
                    <div class="bar">
                        <ul>
                            <li>111想要</li>
                            <li>100赞</li>
                            <li>3天到期</li>
                        </ul>
                    </div>
                    <div class="godsmessage">
                        <p class="goodsname"><span>品名&nbsp;</span></p>
                        <p><span>类别&nbsp;</span></p>
                        <p class="discript"><span>描述信息&nbsp;</span></p>
                    </div>
                    <button>修改</button>
                </article>
            </section>
</article>

<!-- 页面脚 -->
<footer class="footer">
            <article class="more"></article>
<!--
            <article class="authormessage">
                <p><span>辛丙亮&nbsp;&nbsp;出品;</span>&nbsp;&nbsp;Tel:15102724518;&nbsp;&nbsp;QQ:709464835</p>
                <p>全站代码开放,代码托管地址(GitHub)&nbsp;&nbsp;<a href="https://github.com/xinbingliang/jie" target="_blank">接下去</a>&nbsp;&nbsp;;期待更多人加入！</p>
            </article>
        </footer>
    </section>
</body>
</html>-->

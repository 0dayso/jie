<!-- 页面中间位置 -->
<article class="content">
        <!-- 单品展示位置 -->
    <section class="left">
            <div class="goods">
                <!-- 品名 -->
                <h3><?php echo "$goodsname";?></h3>
                <!-- 图片轮播 -->
                <div class="banner" id="unslider">
                    <ul>
               			<?php
							for($i=0; $i<4; $i++){
								$name = 'goodsimg'.$i;
								if($$name != null){
									$imgname = INLET.'goodsimg/'.$$name;
									echo "<li><img src='{$imgname}' alt='' width='400' height='400' ></li>";			
								}				
							} 
						?>
                    </ul>
                    <a href="javascript:void(0);" class="unslider-arrow prev"><img class="arrow" id="al" src="http://localhost/jie/App/View/img/arrowl.png" alt="prev" width="20" height="35"></a>
                    <a href="javascript:void(0);" class="unslider-arrow next"><img class="arrow" id="ar" src="http://localhost/jie/App/View/img/arrowr.png" alt="next" width="20" height="37"></a>
                </div>
                <!-- 图片轮播结束 -->
                <!-- 描述信息 -->
                <p class="discript"><?php echo "$goodsdepict";?><span><?php echo $day;?></span></p>
                <!-- 可点击的按钮 -->
                <ul class="menu">
                    <li><a href="javascript:void(0);"><?php echo $pay;?></a></li>
                    <li><a href="javascript:void(0);"><?php echo $commentnum;?>评论</a></li>
                    <li><a href="javascript:void(0);"><?php echo $want;?>想要</a></li>
                    <li><a href="javascript:void(0);"><?php echo $zannum;?>赞</a></li>
                </ul>
                <div class="godsmessage">
                    <section class="send">
                        <form action="" method="post" id="disform">
                            <img src="<?php echo INLET.'headimg/'.$_SESSION['user']['userimg']?>" width="45px" height="45px">
                            <label for="entersend">
                                <input id="entersend" name="entersend" type="text" placeholder="评论"/>
                            </label>
                            <span id="entermessage">&nbsp;&nbsp;</span><input type="submit" value="评论" class="submit" id="discuss"/>
                        </form>
                    </section>
                    <!-- 用户评论区 -->
                    <section class="comment">
                        <?php 
                            foreach ($data as $value){
                                echo "<article>
                                            <img src='{$value['userimg']}' width='45px' height='45px'>
                                            <div class='message'>
                                                <p><span>{$value['username']}</span>:<span>{$value['gdcontent']}</span></p>
                                                <p><span class='distime'>{$value['gdtime']}</span><a href='javascript:void(0);'>回复</a></p>
                                            </div>
                                        </article>";
                            }
                        ?>
                    
<!--                        <article>
                            <img src="" width="45px" height="45px">
                            <div class="message">
                                <p><span>用户名</span>:<span>评论内容评论内容评论内容评论内容评论内容评论内容评论内容评论内容评论内容评论内容</span></p>
                                <p><span class="distime">刚刚</span><a href="javascript:void(0);">回复</a></p>
                            </div>
                        </article>
                        <article>
                            <img src="" width="45px" height="45px">
                            <div class="message">
                                <p><span>用户名</span>:<span>评论内容评论内容</span></p>
                                <p><span class="distime">2015-4-13 12:35:12</span><a href="javascript:void(0);">回复</a></p>
                            </div>
                        </article>
                        <article>
                            <img src="" width="45px" height="45px">
                            <div class="message">
                                <p><span>用户名</span>:<span>评论内容评论内容评论内容评论内容评论</span></p>
                                <p><span class="distime">2015-4-13 12:35:12</span><a href="javascript:void(0);">回复</a></p>
                            </div>
                        </article>-->
                    </section>
                    <!-- 用户评论区结束 -->
                </div>
            </div>
        </section>
        <!-- 简单的用户信息 -->
    <section class="blown">
            <article>
                <div class="img"></div>
                <p>发贴时间:&nbsp;&nbsp;<span class="time"><?php echo $goodstime;?></span></p>
                <p><span class="type">姓名:&nbsp;&nbsp;</span><span><?php echo $username;?></span></p>
                <p><span class="type">性别:&nbsp;&nbsp;</span><span><?php echo $gender;?></span></p>
                <p><span>积分:&nbsp;&nbsp;<?php echo $point;?></span>&nbsp;&nbsp;=&nbsp;&nbsp;123￥</p>
                <a href="javascript:void(0);">与物主沟通</a>
            </article>
        </section>
</article>
<!-- 页面脚 -->
<footer class="footer">
    <article class="more"></article>

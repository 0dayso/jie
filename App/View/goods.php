<!-- 页面中间位置 -->
<article class="content">
        <!-- 单品展示位置 -->
    <section class="left">
            <div class="goods">
                <!-- 品名 -->
                <h3 id="goodsname"><?php echo "$goodsname";?></h3>
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
                    <?php
                        if(!empty($goodsimg1)){
                            echo '<a href="javascript:void(0);" class="unslider-arrow prev"><img class="arrow" id="al" src="http://localhost/jie/App/View/img/arrowl.png" alt="prev" width="20" height="35"></a>
                            <a href="javascript:void(0);" class="unslider-arrow next"><img class="arrow" id="ar" src="http://localhost/jie/App/View/img/arrowr.png" alt="next" width="20" height="37"></a>';
                        }
                    ?>
                </div>
                <!-- 图片轮播结束 -->
                <!-- 描述信息 -->
                <a name="reply"></a>
                <p class="discript"><?php echo "$goodsdepict";?><span><?php echo $day;?></span></p>
                <!-- 可点击的按钮 -->
                <ul class="menu">
                    <li><a href="javascript:void(0);"><?php echo $pay;?></a></li>
                    <li><a href="javascript:void(0);"><span id='commentnum'><?php echo $commentnum;?></span><i class="demo-icon icon-comment">&#xe83f;</i></a></li>
                    <li><a href="javascript:void(0);" id="want"><span><?php echo $want;?></span><i class="demo-icon icon-cart-plus">&#xe84d;</i></a></li>
                    <li><a href="javascript:void(0);"  onclick='Zambia(this)' data-goodsid='<?php echo $goodsid;?>'><span><?php echo $zannum;?></span><i class="demo-icon icon-thumbs-up">&#xe838;</i></a></li>
                </ul>
                <div class="godsmessage">
                    <section class="send">
                        <form action="" method="post" id="disform">
                            <img id="fuserimg" src="<?php echo INLET.'headimg/'.$_SESSION['user']['userimg']?>" width="30px" height="30px">
                            <label for="entersend">
                                <input type="hidden" id="userid" value="<?php echo $_SESSION['user']['userid']?>"/>
                                <input type="hidden" id="username" value="<?php echo $_SESSION['user']['username']?>"/>
                                <input id="entersend" name="entersend" type="text" placeholder="评论"/>
                            </label>
                            <span id="entermessage">&nbsp;&nbsp;</span><input type="submit" value="评论" class="submit" id="discuss"/>
                        </form>
                    </section>
                    <!-- 用户评论区 -->
                    <section class="comment" id="comment">
                        <?php 
                         if(!empty($data)){
                             foreach ($data as $value){
                                 $content = empty($value['tousername'])?$value['gdcontent']:'回复<a href="">'.$value['tousername'].'</a>:'.$value['gdcontent'];
                                 echo "<article>
                                 <img src='{$value['userimg']}' width='30px' height='30px'>
                                 <div class='message'>
                                 <p>{$value['username']}:{$content}</p>
                                 <p><span class='distime'>{$value['gdtime']}</span><a data-userid='{$value['userid']}' data-username='{$value['username']}' href='#reply' class='reply'>回复</a></p>
                                 </div>
                                 </article>";
                             }     
                         }   
                        ?>
                    </section>
                    <?php 
                        //判断是否有更多消息，放置上一页下一页按钮
                        if(isset($_SESSION['goodsdiscuss'])&&$_SESSION['goodsdiscuss'] ==10){
                            echo "<div class='messbutton'><button id='pre'><i class='demo-icon icon-angle-left'>&#xe858;</i></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button id='nex'><i class='demo-icon icon-angle-right'>&#xe859;</i></button></div>";
                        }
                    ?>
                    <!-- 用户评论区结束 -->
                </div>
            </div>
        </section>
        <!-- 简单的用户信息 -->
    <section class="blown">
            <article class="goodsuser">
                <img src="<?php echo $userimg;?>">
                <p>发贴时间:&nbsp;&nbsp;<span class="time"><?php echo $goodstime;?></span></p>
                <p><span class="type">姓名:&nbsp;&nbsp;</span><span id="touserid"><?php echo $goodsUsername;?></span></p>
                <p><span class="type">性别:&nbsp;&nbsp;</span><span><?php echo $goodsgender;?></span></p>
                <p><span>积分:&nbsp;&nbsp;<?php echo $point;?></span>&nbsp;&nbsp;=&nbsp;&nbsp;123￥</p>
                <?php 
                    $userid = $_SESSION['user']['userid'];
                    $guserid = $_SESSION['goods']['userid'];  
                    if ($userid == $guserid) {
                        echo "<a href='javascript:void(0);' id='chioce' style='background-color: #ccc;'>选择您希望被赠予的对象</a>";
                    } else {
                        echo "<a href='javascript:void(0);' id='goodschat' data-chatuserid='{$chatuserid}' >与物主沟通</a>";
                    } 
                
                ?>
                
                <!-- <a href="javascript:void(0);" id="goodschat" data-chatuserid="<?php echo $chatuserid;?>" >与物主沟通</a> -->
            </article>
            <article class="choiceuser">
                <ul id="userlistbox">
                <?php
                    /* var_dump($userList);  */
                    $allnum = count($userList);
                    $num = 0;
                    if (!empty($userList)) {
                        for ($num = 0; $num < $allnum; $num++) {
                            $userid = $userList[$num]['userid'];
                            $href = 'http://localhost/jie/index.php/User/Index&userid='.$userid;
                            $username = $userList[$num][0]['username'];
                            $userimg = INLET.'headimg/'.$userList[$num][0]['userimg'];
                            echo "<li  onclick='clickChico(this)' data-userid='{$userid}'><img src='{$userimg}' width='35px' height='35px'/><span>{$username}</span></li>";
                        }
                    }
                ?>
                </ul>
                <?php 
                    if($num == 20){
                        echo '<p class="left"><button id="userlistpre"><i class="demo-icon icon-angle-left">&#xe858;</i></button></p>
                <p class="right"><button id="userlistnex"><i class="demo-icon icon-angle-right">&#xe859;</i></button></p>';
                    }
                ?>
            </article>
        </section>
</article>
<!-- 页面脚 -->
<footer class="footer">
    <article class="more"></article>

    
    
    
    
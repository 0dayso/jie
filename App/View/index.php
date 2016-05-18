<article class="content">
    <section class="message" id="message">
                <?php 
                    if(!empty($goodsbox)){
                        while ($goodsbox->TheValue()){
                            //获得单个货物信息
                            $oneGoods = $goodsbox->current();
                            $goodsid = $oneGoods['goodsid'];
                            $userid =  INLET.'index.php/User/Index&userid='.$oneGoods['userid'];
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
                            $goodspath = INLET.'index.php/Goods/Index&gid='.$goodsid;
                        
                            /* 判断类型  */
                            if($paynum == 0 || $paytype== 0){
                                $str = '<i class="demo-icon icon-gift">&#xe869;</i>';
                            } else if($paytype == 1) {
                                $str =  $paynum.'<i class="demo-icon icon-yen">&#xe86c;</i>';
                            } else {
                                $str = $paynum.'<i class="demo-icon icon-database">&#xe86f;</i>';
                            }
                        
                            echo "<article>
                            <div class='img'><a href='{$goodspath}'><img src='{$goodsimg0}' width='280px' height='280px'></a></div>
                            <div class='userandtime'>
                            <a href='{$userid}' class='head'><img src='{$userimg}' width='45px' height='45px'></a>
                            <span class='username'>{$username}</span>
                            <span class='timeout'>{$day}天过期<!--<i class='demo-icon icon-bell-alt'>&#xe843;</i>--></span>
                            </div>
                            <ul>
                            <li><a>$str</a></li>
                            <li><a href='{$goodspath}'>{$commentnum}<i class='demo-icon icon-comment'>&#xe83f;</i></a></li>
                            <li><a href='javascript:void(0);' onclick='Zambia(this)' data-goodsid='{$goodsid}'><span>{$zannum}</span><i class='demo-icon icon-thumbs-up'>&#xe838;</i></a></li>
                            </ul>
                            <div class='godsmessage'>
                            <p class='goodsname'>{$goodsname}</p>
                            <p class='discript'>{$goodsdepict}</p>
                            </div>
                            </article>";
                            $goodsbox->next();
                        }
                    }
                ?>
            </section>
    <!-- 发布和信息 -->
    <section class="blown">
                <h2>晒出你的旧物</h2>
                <form class="addgoods" action="<?php echo INLET;?>index.php/PushGoods/SubmitFile" method="post" enctype="multipart/form-data">
                    <label for="goodsname">
                        <input name="goodsname" id="goodsname" class="goodsname" placeholder="请输入旧物名,最多12字"/>
                        <span id="gnamemessage" class="errormess">&nbsp;</span>
                    </label>
                    <label for="goodsdis">
                        <textarea class="goodsdis" id="goodsdis" name="goodsdis" placeholder="输入对旧物的描述,最多110字符"></textarea>
                        <span id="gdmessage"  class="errormess">&nbsp;</span>
                    </label>
                    <div id="imgbox">
                        <input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>
                        <div><input type="file" class="file" name="file[]"/><span>上传图片</span></div>
                        <div id="box1"><input type="file" class="file" name="file[]"/><span>上传图片</span></div>
                        <div id="box2"><input type="file" class="file" name="file[]"/><span>上传图片</span></div>
                        <div id="box3"><input type="file" class="file" name="file[]"/><span>上传图片</span></div>
                    </div>
                    <div class="type">
                        <label for="free" class="rad"><input class="select" type="radio" name="type" value="0" checked id="free"><span>免费</span></label>
                        <label for="rmb" class="rad"><input class="select" type="radio" name="type" value="1" id="rmb"/><span>人民币</span></label>
                        <label for="num" class="rad"><input class="select" type="radio" name="type" value="2" id="num"/><span>积分</span></label>
                    </div>
                    <div id="typeactive" class="typeactive">
                        <div><span>感谢您为社区带来的免费分享！</span></div><span class="errormess"id="payerror"></span>
                    </div>
                    <input type="submit" name="submit" class="submit" value="发&nbsp;布"/>
                </form>
            </section>
</article>

<section class="outface loginform">
    <h2>登&nbsp;&nbsp;录</h2><a href="javascript:void(0);" id="closelogin"><i class="demo-icon icon-cancel-1">&#xe87f;</i></a>
    <form action="<?php echo INLET;?>index.php/index/Log" method="post">
        <label for="lemail"><input type="text" id="lemail" name="email" placeholder="请输入您的邮箱"/><br/><span id="lemailmessage"  class="formerror">&nbsp;&nbsp;</span></label>
        <label for="password"><input type="password" id="lpassword" name="password" placeholder="请输入您的密码"><br/><span id="lpasswordMessage" class="formerror">&nbsp;&nbsp;</span></label>
        <input class="loginsubmit" type="submit" value="登&nbsp;&nbsp;&nbsp;录"/>
    </form>
</section>
<section class="outface registerform">
    <h2>注&nbsp;&nbsp;册</h2><a href="javascript:void(0);" id="closeregister"><i class="demo-icon icon-cancel-1">&#xe87f;</i></a>
    <form action="<?php echo INLET;?>index.php/index/Reg" method="post">
        <label for="idcard"><input type="text" id="idcard" name="idcard" placeholder="请输入身份证号"/><br/><span id="idcardmessage" class="formerror">&nbsp;&nbsp;</span></label>
        <label for="username"><input type="text" id="username" name="username" placeholder="请输入真实姓名"/><br/><span id="namemessage" class="formerror">&nbsp;&nbsp;</span></label>
        <label for="email"><input type="text" id="email" name="email" placeholder="请输入您的邮箱"><br/><span id="emailmessage" class="formerror">&nbsp;&nbsp;</span></label>
        <label for="password" class="passwordlast"><input type="password" id="password" name="password" placeholder="请输入您的密码"><br/><span id="passwordmessage"  class="formerror">&nbsp;&nbsp;</span></label>
        <input class="rigistersubmit" type="submit" value="注&nbsp;&nbsp;&nbsp;册"/>
    </form>
</section>
<!--<section class="outface showmessage">
    <h2>信&nbsp;息&nbsp;提&nbsp;示</h2><a href="javascript:void(0);" id="closelogin"><i class="demo-icon icon-cancel-1">&#xe87f;</i></a>
    <p id="showmess">
        没有更多了
    </p>
</section>-->
<!-- 页面脚 -->
<footer class="footer">
    <article class="more"><div><p id="morebox"><button id="more">接下去</button><i class="demo-icon icon-spin6 animate-spin">&#xe814;</i></p></div></article>

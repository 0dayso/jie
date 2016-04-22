<article class="content">
    <section class="message" id="message">
                <?php 
                    $goodsbox->rewind();
                    while ($goodsbox->TheValue()){
                        //获得单个货物信息
                        $oneGoods = $goodsbox->current();
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
                            <div class='img'><a href='{$goodspath}'><img src='{$goodsimg0}' width='280px' height='280px'></a></div>
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
    <article class="more"><div><button id="more">接下去</button></div></article>
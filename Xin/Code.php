<?php
namespace Xin;
/**
* 文件描述: 验证码生成类
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月29日 下午3:39:13
* @version 1.0.0
* @copyright  CopyRight
*/
class Code{
    /**
    * 描述: 生成验证码字符
    * @date: 2016年4月29日 下午3:40:14
    * @author: xinbingliang <709464835@qq.com>
    * @param: $type 生成随机字符串， 1全数字,2全字母,3字母和数字混合
    * @param: $length 生成随机字符串的长度
    * @return:
    */
    static function buildRandomString($type=1,$length=4){
        if ($type == 1) {
            $chars = join ( "", range ( 0, 9 ) );
        } elseif ($type == 2) {
            $chars = join ( "", array_merge ( range ( "a", "z" ), range ( "A", "Z" ) ) );
        } elseif ($type == 3) {
            $chars = join ( "", array_merge ( range ( "a", "z" ), range ( "A", "Z" ), range ( 0, 9 ) ) );
        }
        if ($length > strlen ( $chars )) {
            exit ( "字符串长度不够" );
        }
        $chars = str_shuffle ( $chars );
        return substr ( $chars, 0, $length );
    }
    
    /**
    * 描述: 绘制验证码图片,并将字符串保存到session中
    * @date: 2016年4月29日 下午3:41:00
    * @author: xinbingliang <709464835@qq.com>
    * @param: $type 生成随机字符串， 1全数字,2全字母,3字母和数字混合
    * @param: $length 生成随机字符串的长度
    * @param: $pixel 绘制干扰点
    * @param: $line 绘制干扰线
    * @param: $sess_name 在session中的名称
    * @return:
    */
    static function verifyImage($type=1,$length=4,$pixel=0,$line=0,$sess_name = "code"){
        /* session_start(); */
        //创建画布
        $width = 80;
        $height = 34;
        $image = imagecreatetruecolor ( $width, $height );
        $white = imagecolorallocate ( $image, 255, 255, 255 );
        $black = imagecolorallocate ( $image, 0, 0, 0 );
        //用填充矩形填充画布
        imagefilledrectangle ( $image, 1, 1, $width - 2, $height - 2, $white );
        $chars = self::buildRandomString( $type, $length );
        $_SESSION [$sess_name] = $chars;
        //$fontfiles = array ("MSYH.TTF", "MSYHBD.TTF", "SIMLI.TTF", "SIMSUN.TTC", "SIMYOU.TTF", "STZHONGS.TTF" );
/*         $fontnum = rand(1, 22) */
        
/*         $fontfiles = array ("SIMYOU.TTF" ); */
        //由于字体文件比较大，就只保留一个字体，如果有需要的同学可以自己添加字体，字体在你的电脑中的fonts文件夹里有，直接运行输入fonts就能看到相应字体
        for($i = 0; $i < $length; $i ++) {
            $size = mt_rand ( 14, 18 );
            $angle = mt_rand ( - 15, 15 );
            $x = 5 + $i * $size;
            $y = mt_rand ( 20, 26 );
            $fontfile = ROOT."Font/" . mt_rand ( 1, 22 ).'.ttf';
/*             echo $fontfile;
            exit(); */
            $color = imagecolorallocate ( $image, mt_rand ( 50, 210 ), mt_rand ( 80, 210 ), mt_rand ( 90, 210 ) );
            $text = substr ( $chars, $i, 1 );
            imagettftext( $image, $size, $angle, $x, $y, $color, $fontfile, $text );
        }
        if ($pixel) {
            for($i = 0; $i < 50; $i ++) {
                imagesetpixel ( $image, mt_rand ( 0, $width - 1 ), mt_rand ( 0, $height - 1 ), $black );
            }
        }
        if ($line) {
            for($i = 1; $i < $line; $i ++) {
                $color = imagecolorallocate ( $image, mt_rand ( 50, 90 ), mt_rand ( 80, 200 ), mt_rand ( 90, 180 ) );
                imageline ( $image, mt_rand ( 0, $width - 1 ), mt_rand ( 0, $height - 1 ), mt_rand ( 0, $width - 1 ), mt_rand ( 0, $height - 1 ), $color );
            }
        }
        header ( "content-type:image/gif" );
        imagegif ( $image );
        imagedestroy ( $image );
    }
    
}

?>
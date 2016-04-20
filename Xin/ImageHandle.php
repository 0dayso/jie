<?php
namespace Xin;

class ImageHandle{
    
    /**
    * 描述: 图片缩放
    * @date: 2016年4月20日 下午5:12:14
    * @author: xinbingliang <709464835@qq.com>
    * @param: $width 要保存的宽度
    * @param: $height  保存的高度
    * @param: $filename  完整路径的文件名
    * @param: $dir  保存的路径
    * @param: variable
    * @return:
    * 
    */
    static  function Tumb($width, $height, $filename, $dir){
         $array = getimagesize($filename);
         $width_orig = $array[0];
         $height_orig = $array[1];
         $type = explode('/', $array['mime']);
         $type = $type[1];
         
         
         if ($width && ($width_orig < $height_orig)) {
             $width = ($height / $height_orig) * $width_orig;
         } else {
             $height = ($width / $width_orig) * $height_orig;
         }
        
         // Resample
         $image_p = imagecreatetruecolor($width, $height);
         $fun = 'imagecreatefrom'.$type;
         $image = $fun($filename);
         imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
        
         // Output
         $outfun = 'image'.$type;
         $fname = trim($dir, '/').'/'.basename($filename);
         $outfun($image_p, $fname); 
         unlink($filename);
         imagedestroy($image_p);
         imagedestroy($image);
    }
    
}

?>
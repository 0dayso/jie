<?php
namespace App\Model;
/**
* 文件描述: 用来存放商品信息,使用迭代器
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月21日 下午7:12:32
* @version 1.0.0
* @copyright  CopyRight
*/

class GoodsBox implements \Iterator{
    //存放货物信息数组
    private $goods = array();
    //键位置
    private $position = 0;
    
    
    /**
     * 描述: 自定义用来存入货物的方法
     * @date: 2016年4月21日 下午7:20:22
     * @author: xinbingliang <709464835@qq.com>
     * @param: variable
     * @return:
     */
    public function __construct($goodsArray){
        $this->goods = $goodsArray;
    }
    
    //返回当前元素
    public function current(){
        return $this->goods[$this->position];
    }
    
    //返回当前的键
    public function key(){
        return $this->position;
    }
    
    
    //下移一个元素
    public function next(){
        ++$this->position;
    }
    
    
    //移动到第一个元素
    public function rewind(){
        $this->position = 0;
    }
    
    
    //判断后续是否还有元素,基础函数中会包含此方法
    public function valid(){
        return isset($this->goods[$this->position+1]);
    } 
    
    /**
    * 描述: 判断当前指针位置是否有数据,这是一个添加的方法
    * @date: 2016年4月22日 上午10:15:43
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    public function TheValue(){
        return isset($this->goods[$this->position]);
    }
    
    /**
    * 描述: 向商品信息中添加发布者的信息
    * @date: 2016年4月21日 下午7:25:23
    * @author: xinbingliang <709464835@qq.com>
    * @param: variable
    * @return:
    */
    function AddUser($key , $name, $value){
        $this->goods[$key][$name] = $value;
    }
    
    /**
    * 文件描述  返回容器中的所有数据
    *
    * @author     xinbingliang <709464835@qq.com>
    * @date 2016年4月22日 下午1:17:08
    * @version 1.0.0
    * @copyright  Copyright 2016 xinbingliang.cn
    */
     function GetAll(){
         return $this->goods;
     }
}

?>
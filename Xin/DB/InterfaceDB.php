<?php
namespace Xin\DB;

interface InterfaceDB{
    //连接数据库
    static function MyConnect();
    //插入数据
    function Insert($table, $array);
    //更新数据
    function Update($table, $array, $where=NULL);
    //删除记录，必须有条件才能删除
    function Delete($table, $where=NULL);
    //得到一个结果集并以数组形式返回
    function FetchAll($table, $array=NULL, $where=NULL, $limit=NULL);
    //得到记录的数量
    function FecthAllNum($sql);
}
?>
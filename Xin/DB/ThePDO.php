<?php
namespace Xin\DB;
/**
* 文件描述: 使用pdo对数据的处理,使用单例模式
*
* @author      辛丙亮 <709464835@qq.com>
* @date 2016年4月9日 下午2:27:02
* @version 1.0.0
* @copyright  CopyRight
*/

class ThePDO implements InterfaceDB{
    //存储pdo对象
    private static $pdo = NULL;
    //存储自身对象
    private static $self = NULL; 
    
    /**
    * 描述: 在构造函数上操作，使pdo的唯一性和对象本身进行绑定
    * @date: 2016年4月9日 下午2:40:09
    * @author: xinbingliang <709464835@qq.com>
    */
    private function __construct(){
        $messageObj = new \Xin\Loadconfig(ROOT.'configs/');
        $dbMessag = $messageObj->offsetGet('DB');
        $dsn = "mysql:dbname={$dbMessag['db']};host={$dbMessag['host']}";
        $user = $dbMessag['user'];
        $password = $dbMessag['password'];
        try{
            if(self::$pdo == NULL){
                $pdo = new \PDO($dsn, $user, $password);
                
            }
        }catch (\PDOException $e){
             $dbConnectMeaaage = '数据库连接失败,错误原因:'.$e->getMessage()."\n";
             file_put_contents(ROOT.'message.txt', $dbConnectMeaaage);
        }
        self::$pdo = $pdo;
        //错误抛出PDOException异常对象,上线时要做调整
        self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        self::$pdo->exec('set names utf8');
    }
    
    /**
    * 描述: 单列模式返回对象自身
    * @date: 2016年4月9日 下午3:12:39
    * @author: xinbingliang <709464835@qq.com>
    * @return: self
    */
    static function MyConnect(){
        if (self::$self == NULL){
            self::$self = new self(); 
        }
        return self::$self;
    }
    
    /**
    * 描述: 插入语句
    * @date: 2016年4月9日 下午5:19:15
    * @author: xinbingliang <709464835@qq.com>
    * @param: $table 要操作的表
    * @param: $array 以键为表字段，值为对应字段值的数组
    * @return: 返回执行成功的数据量
    */
    function Insert($table, $array){
        /* $array = $this->MyQuote($array);  */
        $table = $this->AddSign($table);
        $keys = join(", ", array_keys($array));
        $values = array_values($array);
        $length = count($values);
        $param = "";
        for ($i=0; $i<$length; $i++){
            $param .= '?,';
        }
        $param = trim($param, ',');
        $sql="insert into {$table} ($keys) values({$param})";
        try {
            $stmt = self::$pdo->prepare($sql);
            $result = $stmt->execute($values);
            return  $result;
        }catch(\PDOException $e){
            file_put_contents(ROOT.'message.txt', $e->getMessage());
        }
    }
    
    /**
    * 描述: 修改表中的数据，对没有$where强制不执行
    * @date: 2016年4月9日 下午5:21:04
    * @author: xinbingliang <709464835@qq.com>
    * @param: $table 要修改的表名
    * @param: $array 要修改的数据,以字段名为键,以改变值为值
    * @param: $wher 设定是修改条件
    * @return: 返回影响的数据量
    */
    function Update($table, $array, $where=NULL){
        //上线时要做修改
        if($where == NULL){
            file_put_contents(ROOT.'message.txt', "尝试修改全表数据\n");
            exit('尝试全表数据');
        }
        //添加表前缀
        $table = $this->AddSign($table);
        //update table_name set key1=value,$key2=value where 
        //组装数据
        $key = array_keys($array);
        $value = array_values($array);
/*         $setArray = array_map('self::Func', $key, $value);
        $set = join(',', $setArray); */
        $setArray = array();
        for($i=0; $i<count($key); $i++){
            $setArray[] = $key[$i].' = '."'{$value[$i]}'";
        }

        $set = join(',', $setArray);
        //组装sql语句
        $sql = "update {$table} set {$set} where {$where}";

        try {
            //执行sql语句
            $attfected = self::$pdo->exec($sql);
            //返回执行结果
            return $attfected;
        } catch (\PDOException $e) {
            file_put_contents(ROOT.'message.txt', $e->getMessage());
        }
    }
    
    /**
    * 描述: 删除数据行，不允许在没有条件的情况下对数据表进行删除
    * @date: 2016年4月9日 下午7:48:04
    * @author: xinbingliang <709464835@qq.com>
    * @param: $table 被操作表的名称
    * @param: 删除数据时给定的条件
    * @return: 返回被影响的行数
    */
    function Delete($table, $where=NULL){
        //上线时要做修改
        if($where == NULL){
            file_put_contents(ROOT.'message.txt', "尝试删除全表数据\n");
            exit('尝试删除全表数据');
        }
        //添加表前缀
        $table = $this->AddSign($table);
        //delete from table_name where $where
        //组装sql语句
        $sql = "delete from {$table} where {$where}";
        try {
            //执行sql
            $sttfected = self::$pdo->exec($sql);
            //返回结果
            return $sttfected;
        } catch (\PDOException $e) {
            file_put_contents(ROOT.'message.txt', $e->getMessage());
        }
    }
    
    /**
    * 描述: 查询语句，可以以后修改为预处理形式，以提高效率
    * @date: 2016年4月9日 下午8:17:09
    * @author: xinbingliang <709464835@qq.com>
    * @param: $table 查询的表
    * @param: $array 要查询的字段
    * @param: $where 查询的条件
    * @param: $limit 要查询出的行数     
    * @return: 返回查询到的索引数组
    * 
    */
    function FetchAll($table, $where=NULL, $array=NULL,  $limit=NULL, $desc=NULL){
        //添加表前缀
        $table = $this->AddSign($table);
        //组装要查询的字段
        $trad = empty($array)?'*':join(' ,', $array);
        $where = empty($where)?'':'where '.$where; 
        $limit = empty($limit)?'':$limit;
        $desc = empty($desc)?'':$desc;
        //组装sql语句
        $sql = "select {$trad} from {$table} {$where} {$desc} {$limit} ";
/*           file_put_contents(ROOT.'message.txt', $sql); 
        exit();    */      
        try {
            //执行语句
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute();
            //获取结果集
            $allRows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $data = array();
            //得到关联数组的形式
            foreach ($allRows as $row){
                $data[] = $row;
            }
            //返回数据
            return empty($data)?null:$data;
        } catch (\PDOException $e) {
            file_put_contents(ROOT.'message.txt', $e->getMessage());            
        }
    }

    //添加单条数据获取方式
    function FetchOne($table, $where, $array){
        //添加表前缀
        $table = $this->AddSign($table);
        
        $field = join(' ,', $array);
        trim($field, ',');
        list($key, $value) = each($where);
        $where = " where $key = ? "; 
        $sql = "select {$field} from {$table} {$where}";
/*         echo $sql;
        exit();  */
        try {
            //准备申明好的查询
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute(array($value));
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $data;
        }catch(\PDOException $e){
            file_put_contents(ROOT.'message.txt', $e->getMessage().date("Y-m-d H:i:s", time()));
        }
        
    }
    
    function FecthAllNum($sql){
        try {
            /* $pdoStatement = self::$pdo->prepare($sql);
            $pdoStatement->execute();
            return $pdoStatement->rowCount(); */
            $res = self::$pdo->query($sql);
            $row=$res->fetch(\PDO::FETCH_NUM);//PDO处理结果集
            if(empty($row[0])){
                return null;
            }else{
                return $row;
            }
        } catch (\PDOException $e) {
            file_put_contents(ROOT.'message.txt', $e->getMessage().date("Y-m-d H:i:s", time()));
        }
    }
    
    private function AddSign($table){
        return 'j_'.$table; 
    }
}
?>
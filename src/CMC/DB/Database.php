<?php
//version 1.01
namespace CMC\DB;

use PDO;

/*******類別定義*****/
class Database
{
    private $host;
    private $user;
    private $pass;
    private $port;
    private $dbname;
    private $charactor;
    
    private $dbh;
    private $error;
    private $stmt;
    
    private $debug_sql;
    
    public function __construct($config, $str='set names utf8')
    {
        //初始設定
        $this->host         = $config['host'];
        $this->user         = $config['user'];
        $this->pass         = $config['pass'];
        $this->port         = empty($config['port']) ? 3306 : $config['port'];
        
        $this->dbname       = $config['db'];
        $this->charactor    = empty($config['charactor']) ? 'UTF8' : strtoupper($config['charactor']);
        ##        
        
        // 設定 DSN
        $dsn = 'mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->dbname;
        ##
        
        // 設定 options 遇到big5時 初始化物件加上big5字串
        if($this->charactor == 'BIG5') $options = [];
        else {
            $options = [
                PDO::ATTR_PERSISTENT            => false,
                PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND    => $this->charactor,
                PDO::MYSQL_ATTR_INIT_COMMAND    => 'SET CHARACTER SET '.$this->charactor,
                PDO::ATTR_EMULATE_PREPARES      => true,
            ];
        }
        ##
        
        // 新增 PDO instanace
        try
		{
			$this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        }
        catch(PDOException $e)
		{
            // set error log
            $log = dirname(__DIR__).'/log/db';
            
            if (!is_dir($log)) {
                mkdir($log, 0777, true);
            }
            ##
        
            file_put_contents(
                $log.'/error_'.date("Ymd").'.log',
                date("Y-m-d H:i:s").
                "\n".print_r($e->getMessage(), true).
                "\ndsn：".print_r($dsn, true)."\n\n",
                FILE_APPEND
            );
        }
        ##
    }
    
    public function getDBname()
    {
        return $this->dbname();
    }
    
    public function setDBname($dbname)
    {
        $query = 'use '.addslashes($dbname);
        return $this->getPrepare($query);
    }

    //bindValue
    public function bind($param, $value, $type=NULL)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;

                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;

                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;

                default:
                    $type = PDO::PARAM_STR;
                    break;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    //prepare
    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }
    ##

    //execute
    public function go($data=[])
    {
        if (empty($data)) return $this->stmt->execute();
        else {
            foreach ($data as $param => $value) {
                // $this->bind($param, $value);
                $this->bind($param, $value, PDO::PARAM_STR);
            }
            return $this->stmt->execute($data);
        }
    }
    ##

    //prepare + execute
    public function getPrepare($query, $data=[])
    {
        $this->debug_params($query, $data);
        $this->query($query);
        return $this->go($data);
    }
    ##
    
    //prepare + execute
    public function exeSql($query, $data=[])
    {
        return $this->getPrepare($query, $data);
    }
    ##
    
    //使用fetchALL時
    public function all($query, $data=[])
    {
        $this->getPrepare($query, $data);
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    ##

    //使用fetch時
    public function one($query, $data=[])
    {
        $this->getPrepare($query, $data);
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    ##

    //傳回被影響的行數
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
    ##

    //返回最後插入資料的id
    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }
    ##    
    
    //To begin a transaction:
    public function beginTransaction()
    {
        return $this->dbh->beginTransaction();
    }
    ##

    //To end a transaction and commit your changes:
    public function endTransaction()
    {
        return $this->dbh->commit();
    }
    ##

    //To cancel a transaction and roll back your changes:
    public function cancelTransaction()
	{
        return $this->dbh->rollBack();
    }
    ##

    //印出執行的 sql 語法
    public function debugDump()
    {
        return $this->stmt->debugDumpParams();
    }
    ##
    
    //列印可執行 sql
    private function debug_params($query, Array $data=NULL) {
        $temp_sql = $query;
        
        if (!empty($data)) {
            foreach($data as $k => $v) {
                $temp_sql = preg_replace('/:'.$k.'/', "'".$v."'", $temp_sql);
            }
        }
        
        $this->debug_sql = $temp_sql;
    }

    public function debug() {
        $this->debug_sql = str_replace(array("\r", "\n", "\r\n", "\n\r"), '', $this->debug_sql);
        return $this->debug_sql;
    }
    ##
}
##
?>

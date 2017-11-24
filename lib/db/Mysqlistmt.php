<?php
/*
 * 使用stmt类的Mysqli驱动
 */

namespace lib\db;

use lib\Saver;
use exception;

class Mysqlistmt
{
    //-------数据库信息--------

    public static $instance;

    private $host;

    private $dbname;

    private $username;

    private $password;

    private $port;

    //----------------------

    private $preSql = array(
        'body' => null,
        'where'=> null,
    );

    private $last_sql;

    private $param = array();

    private $table;

    private $field = '*';

    private $result = array();

    function __construct()
    {

    }

    function connect()
    {
        if(!is_null(self::$instance)) return self::$instance;

        $database = Saver::fetch('database');

        foreach ($this as $key => $r)
        {
            if(isset($database[$key]))
                $this->$key = $database[$key];
        }

        self::$instance = new \mysqli($this->host.':'.$this->port, $this->username, $this->password, $this->dbname);

        //如果连接数据库失败
        if(self::$instance->connect_errno)
            throw new exception\DbException(4001);

        return self::$instance;
    }

    function data($param)
    {
        $this->param = $param;
        return $this;
    }

    function selectT($table)
    {
        $this->table = $table;
        $this->preSql['body'] = "select $this->field from $table";
        return $this;
    }

    function insertT($table)
    {
        $this->table = $table;
        $this->preSql['body'] = "insert into $table (?) values (?)";
        return $this;
    }

    function updateT($table)
    {
        $this->table = $table;
        $this->preSql['body'] = "update $table set value = ?";
        return $this;
    }

    function deleteT($table)
    {
        $this->table = $table;
        $this->preSql['body'] = "delete from $this->table";
        return $this;
    }

    /*
     * $where条件语句，$param对应参数，可能有多个
     */
    function where($where, $param)
    {
        $this->param[] = $param;

        $this->preSql['where'] = " where $where";

        return $this;
    }

    /*
     * 字段获取
     */
    function field($fields)
    {
       if(is_array($fields))
       {
           foreach ($fields as $key => $f)
           {
               $this->field = $this->field.','.$f;
           }
           $this->field = substr($this->field,2);
//           $this->field = substr($this->field,1);
       }
       else
           $this->field = $fields;

       //sql语句重写
       $this->preSql['body'] = "select $this->field from $this->table";

       return $this;
    }

    function execute()
    {
        foreach ($this->preSql as $key =>$s)
        {
            $this->last_sql = $this->last_sql.$this->preSql[$key];
        }

        $stmt =  self::$instance->prepare($this->last_sql);
        if($stmt)
        {
            //循环绑定参数value1=>s,value2=>d
            foreach ($this->param as $key => $p)
            {
                $stmt->bind_param('i', $p);
            }

            $stmt->execute();

            $stmt->store_result();

            $variables = array();
            $data = array();
            $meta = $stmt->result_metadata();

            while($field = $meta->fetch_field())
                $variables[] = &$data[$field->name];

            call_user_func_array(array($stmt, 'bind_result'), $variables);

            $i=0;
            while($stmt->fetch())
            {
                foreach($data as $k=>$v)
                    $this->result[$i][$k] = $v;
                $i++;
            }

            $stmt->close();
        }
        /* close connection */
        self::$instance->close();
        return $this->result;
    }
}
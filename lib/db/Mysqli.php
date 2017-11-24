<?php
/*
 * Mysql数据库类,where应该分离出sql主体，是可有可无的状态。没有where则默认全体
 */

namespace lib\db;

use lib\Rcode;
use lib\Saver;
use exception;
class Mysqli implements IDb
{
    public static $instance;

    private $host;

    private $dbname;

    private $username;

    private $password;

    private $port;

    private $socket;

    private $table = null;

    private $preSql = array(
        'body' => null,
        'where'=> null,
    );

    private $param = array(

    );

    private $result;

    /*
     * 初次使用时获得数据库连接
     * 再次使用时获得静态对象
     */
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

    function hi()
    {
        print_r('hi,i am Mysqli drive');
    }

    /*
     * 插入数据
     */
    function insert($param)
    {
        $field = '';
        $value = '';
        foreach ($param as $key => $p)
        {
            $field = $field.",".$key;
            $value = $value.",".$param[$key];
        }
        $field = substr($field,1);
        $value = substr($value,1);

        $this->preSql['body'] = "insert into $this->table ($field) values ($value)";
        return $this;
    }

    /*
     * 查找数据
     */
    function select($param = null)
    {
        $this->param=$param;
        $this->preSql['body'] = "select $param from $this->table";//param table
        return $this;
    }

    /*
     * 更新数据
     */
    function update($param)
    {
        $update = '';
        foreach ($param as $key => $p)
        {
            $update = $update.','.$key.'='.$param[$key];
        }
        $update = substr($update,1);

        $this->preSql['body'] = "update $this->table set $update";

        return $this;
    }

    /*
     * 删除数据
     */
    function delete()
    {
        $this->preSql['body'] = "delete from $this->table";
        return $this;
    }

    /*
     * 条件
     */
    function where($where)
    {
        if(is_null($where)) throw new exception\DbException(4002);

        $this->preSql['where'] = " where $where";

        return $this;
    }

    /*
     * 排序
     */
    function order($param, $type = 'desc')
    {
        if(is_null($param)) throw new exception\DbException(4003);

        $order = " order by $param $type";
        $this->preSql['order'] = $order;

        return $this;
    }

    /*
     * 限制
     */
    function limit($param)
    {
        if(is_null($param)) throw new exception\DbException(4003);

        $limit = " limit $param";
        $this->preSql['limit'] = $limit;

        return $this;
    }

    /*
     * 联表
     */
    function join(){}

    /*
     * 获得表
     */
    function table($table)
    {
       if(is_null($table))
           throw new exception\DbException(4002);

        $this->table = $table;

       return $this;
    }

    /*
     * 拼凑并执行sql语句，迟点分为2个函数
     */
    function execute()
    {
        //获取preSql数组
       if(!isset($this->preSql['body'])) throw new exception\DbException(4003);

        //拼凑sql
       $sql = '';
       foreach ($this->preSql as $key => $ps)
       {
            $sql = $sql.$this->preSql[$key];
       }
       $this->result = self::$instance->query($sql);

       self::$instance->close();
       return $this;
    }

    /*
     * 将结果集转化为数组
     */
    function Rows()
    {
        while ($row = $this->result->fetch_assoc())
        {
            $rs[] = $row;
        }
        return $rs;
    }

}
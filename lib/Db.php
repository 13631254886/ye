<?php
/*
 * 数据库操作类，所有数据库都通过该类进行数据库操作
 */

namespace lib;

class Db
{
    //数据库连接数组，能支持不同类型的数据库同时操作
    public static $instance = array();

    final protected function __construct()
    {

    }

    /*
     * 自动返回一个db实例
     */
    static function __callStatic($name, $arguments)
    {
        return call_user_func_array([self::getDb(), $name], $arguments);
    }

    /*
     * 取得数据库连接
     */
    static function getDb($dbtype = null)
    {
        if(is_null($dbtype))
            $dbtype = Saver::fetch('database')['type'];

        if(empty(self::$instance))
        {
            $db = 'lib\db\\'.$dbtype;
            self::$instance[$dbtype] = new $db;//选择性实例化对象
            self::$instance[$dbtype]->connect();
            return self::$instance[$dbtype];
        }
        return self::$instance[$dbtype];
    }
}
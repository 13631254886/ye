<?php
/*
 * 缓存基类，自动识别实例化相应缓存
 */

namespace lib;


class Cache
{
    public static $instance;

    final protected function __construct()
    {

    }

    /*
     * 自动返回一个cache实例并执行实例中的方法
     */
    static function __callStatic($name, $arguments)
    {
        if(!self::$instance)
            self::getCache();
        return call_user_func_array([self::$instance, $name], $arguments);
    }

    /*
     * 取得缓存对象
     */
    static function getCache($cache_type = null)
    {
        if(is_null($cache_type))
            $cache_type = ucfirst(strtolower(Saver::fetch('config')['cache_type']));//顺便做了格式处理，处理后首字母大写，其余小写

        if(empty(self::$instance))
        {
            $cache = 'lib\cache\\'.$cache_type;
            self::$instance = new $cache;//选择性实例化对象
            return self::$instance;
        }
        return self::$instance;
    }
}
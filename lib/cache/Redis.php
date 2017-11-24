<?php
/*
 * Redis驱动
 */
namespace lib\cache;

use exception;
class Redis
{
    public static $instance;

    private $config = array(
        'host' => '127.0.0.1',
        'port' => 6379,
        'db'   => 0,
    );

    function __construct()
    {
        //判断是否支持Redis缓存拓展
        if (!class_exists('\Redis')) {
            throw new \BadFunctionCallException('not support: Redis');
        }

        if(is_null(self::$instance))
        self::$instance = new \Redis();

        if(!self::$instance->connect($this->config['host'], $this->config['port']))
            throw new exception\CacheException(5001);

        self::$instance->select($this->config['db']);
    }

    static function get($key)
    {
        return json_decode(self::$instance->get($key));
    }

    static function set($key, $value)
    {
        return self::$instance->set($key, json_encode($value));
    }

    static function remove()
    {

    }

}

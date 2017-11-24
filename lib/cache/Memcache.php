<?php
/*
 * Memcache驱动
 */

namespace lib\cache;

use exception;
class Memcache
{
    private $config = array(
        'host' => '127.0.0.1',
        'port' => 11211,
    );

    public static $instance;

    function __construct()
    {
        //判断是否支持Memcache缓存拓展
        if (!function_exists('memcache_connect')) {
            throw new \BadFunctionCallException('not support: Memcache');
        }

        if(is_null(self::$instance))
            self::$instance = new \Memcache();

        if(!self::$instance->connect($this->config['host'], $this->config['port']))
            throw new exception\CacheException(5001);//缓存服务连接失败
    }

    static function get($key)
    {
        return self::$instance->get($key);
    }

    static function set($key, $value, $time = null)
    {
        self::$instance->set($key, $value);
    }

    static function remove($key = null, $time = null)
    {
        //如果指定key，则删除指定缓存
        if(!is_null($key))
            return self::$instance->delete($key, is_null($time) ? 0 : $time);
        //否则删除全部缓存
        return self::$instance->flush();
    }
}
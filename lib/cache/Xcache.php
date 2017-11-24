<?php
/*
 * Xcache缓存驱动
 * 封装了操作原生Xcache源码的方法
 */
namespace lib\cache;

use lib\Saver;
class Xcache
{
    function __construct()
    {
        //判断是否支持Xcache缓存拓展
        if (!function_exists('xcache_info')) {
            throw new \BadFunctionCallException('not support: Xcache');
        }
    }

    /*
     * 根据name获取缓存
     */
    function get($name = null)
    {
        return xcache_get($name);
    }

    /*
     * 存入缓存
     */
    function set($name, $value, $expire = null)
    {
        //先检查xcache配置，默认缓存时间3600秒
        $expire = $expire ? : Saver::fetch('config')['cache_expire'];
        return xcache_set($name, $value, $expire);
    }

    /*
     * 清除缓存
     */
    function remove($name)
    {
        return xcache_unset($name);
    }

    /*
     * 清除特定缓存
     */
    function removeTag($tag)
    {
        return xcache_unset_by_prefix($tag);
    }
}
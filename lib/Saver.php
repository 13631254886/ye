<?php
/*
 * 存值类，负责保存一些关键数据。建议在程序初始化阶段调用，
 * 由于php在每次请求结束后会释放内存，Saver类会被清空。
 * 每一个Saver只能适用于单个请求内的任何函数调用。
 * 即当前请求存入的值，无法在其他请求中使用
 *
 * Saver::fetch()    获取数据
 * Saver::save()     存入数据
 *
 */
namespace lib;


class Saver
{
    public static $instance;//单例模式

    public $data = array();

    final protected function __construct()
    {
    }

    /*
     * saver实例化
     */
    public static function ini()
    {
        if(is_null(self::$instance)) self::$instance = new Saver();
        return self::$instance;
    }

    /*
     * 获取Saver内数据
     *
     */
    public static function fetch($key = null)
    {
        if(is_null($key))
            return self::ini()->data;
        return isset(self::ini()->data[$key]) ? self::ini()->data[$key] : null;
    }

    /*
     * 将值存入Saver类
     */
    public static function save($key, $value = null)
    {
        //判断该key是否存在
        if(is_array($key))
        {
            self::ini()->data = array_merge(self::ini()->data, $key);
            return $key;
        }

        return self::ini()->data[$key] = $value;
    }

    /*
     * 自动加载__get()函数，判断数组内是否有该元素，若没有则返回空
     */
    public function __get($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    /*
     * __set()同理
     */
    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

}
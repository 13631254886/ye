<?php
/*
 * 框架运行日志类
 * 记录使用者ip，时间，异常操作
 */

namespace core;

use lib\Saver;

class Log
{
    protected static $logs_max_size;

    protected static $log_max_siez;

    /*
     * 获取日志主要信息，用户操作
     */
    public function getMsg()
    {

    }

    public static function write($msg, $type = 'log')
    {
        //判断是否开启日志模式，若没开启直接忽略该操作
        if(!Saver::fetch('config')['log_mode']) return;

        if(!Saver::fetch('config')[$type.'_log']) return;

        $dir = APP_PATH.'.log\\'.DATE.'\\'.date("h");
        //定位日志存放目录
        if(!file_exists($dir))
            @mkdir($dir, 0700,true);

        //命名日志文件 格式为：.日期
        $logname = $dir.'\.'.md5('log-'.DATE);

        //构造日志内容格式 格式为：日志类型：日志信息
        $content = $type.'：'.$msg."\n";

        //写入日志
        file_put_contents($logname, $content, FILE_APPEND);

    }

    /*
     * 当日志占用空间超过一定大小，
     * 清除一部分日志
     * 日志不能主动移除.
     */
    protected function remove()
    {

    }

}
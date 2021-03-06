<?php
/*
 * 常用配置文件
 */
namespace config;

return $config = array(

    //---------------ye版本信息--------------------

    //ye版本号
    'ye_version' => '1.0.1116',

    //--------------------------------------------

    //---------------App程序信息-------------------

    //开发模式
    'app_mode'      =>  'API',

    //是否开启调试
    'debug_mode'    =>  true,

    //---------------------------------------------

    //---------------日志信息------------------------

    //是否开启日志
    'log_mode'      =>  true,

    //系统运行日志
    'runtime_log'   =>  false,

    //用户请求日志
    'request_log'   =>  true,

    //错误异常日志
    'e_log'         =>  false,

    //--------------------------------------------

    //---------------Controller配置----------------

    //默认控制器
    'default_controller' => 'Index',

    //默认方法
    'default_action' => 'index',

    //默认操作
    'default_op' => 'index',

    //---------------------------------------------

    //----------------Router配置--------------------

    //是否开启路由，默认开启
    'router' => true,

    //---------------------------------------------

    //----------------Cache配置---------------------

    //缓存类型
    'cache_type'    =>      'Redis',

    //是否使用缓存
    'cache'         =>       true,

    //缓存时长
    'cache_expire'  =>       3600,

    //----------------------------------------------

);

<?php
/*
 * ye框架启动文件
 */
set_time_limit(0);
//应用程序入口
define('ROOT_PATH', APP_PATH.'app/');
//配置文件入口
define('CONFIG_PATH', APP_PATH.'config/');
//工具类文件入口
define('UTILS_PATH', APP_PATH.'utils/');
//类库文件入口
define('LIB_PATH', APP_PATH.'lib/');
//.php文件后缀
define('EXT', '.php');
//日期
define('DATE', date("ymd"));
//时间
define('TIME', time());
//程序开始时间
define('START_TIME', TIME);

require 'ye'.EXT;
//require 'Error'.EXT;
//core\Error::register();//自动捕获错误异常

$ye = new ye;
$ye->run();
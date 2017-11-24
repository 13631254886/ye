<?php
/*
 * ye框架入口文件
 */

//应用程序入口位置
define('APP_PATH', __DIR__.'\\');
//框架核心文件位置
define('CORE_PATH', __DIR__.'/core/');

//调用框架启动程序
require CORE_PATH.'start.php';
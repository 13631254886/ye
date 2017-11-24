<?php
/*
 * ye框架错误异常处理类
 */

namespace core;


class Error
{
    static function register()
    {
        //屏蔽所有错误报告，交由自定义错误类来处理
        error_reporting(E_ALL);
        set_error_handler(array('core\Error', 'AppError'));
        set_exception_handler(array('core\Error', 'AppException'));
        register_shutdown_function(array('core\Error', 'AppShutDown'));
    }

    /*
     * 自定义错误处理
     * 需要注意一下两点：
     * 第一，如果存在该方法，相应的error_reporting()就不能在使用了。
     * 所有的错误都会交给自定义的函数处理。
     * 第二，此方法不能处理以下级别的错误：
     * E_ERROR、 E_PARSE、 E_CORE_ERROR、 E_CORE_WARNING、 E_COMPILE_ERROR、 E_COMPILE_WARNING，
     * set_error_handler() 函数所在文件中产生的E_STRICT，该函数只能捕获系统产生的一些Warning、Notice级别的错误。
     */
    static function AppError($errno, $errstr, $errfile, $errline)
    {
        $reason = "catch a error in file : $errfile, line : $errline <br>
                            error reason:$errstr<br>";
        print_r($reason);
        Log::write($reason, 'e');
    }

    /*
     * 自定义异常处理
     */
    static function AppException($e)
    {
        //抛出异常后捕获该异常类方法
//         var_dump($e);
    }

    /*
     * 自定义程序终止前调用的最后一个函数，
     * 可以在此记录程序终止日志，原因等
     */
    static function AppShutDown()
    {
//        if($e = error_get_last())
//        {
//            print_r($e);
//        }

    }
}

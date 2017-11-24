<?php
/*
 * 抛出异常处理的中间类
 * 实现了根据模式返回异常类型
 */

namespace exception;

use lib\Rcode;
use core\Log;

class yException extends \Exception
{
    public $code;

    function __construct($code = null)
    {
        parent::__construct();
        $this->code = $code;
        $this->showException();
//        Log::write(TIME, 'Exception');
    }

    /*
     * 显示异常原因
     */
    function showException()
    {
        $rs = Rcode::get($this->code);
        //如果是API模式下，返回对应code的json字符串
        if('API' == APP_MODE)
            exit(json_encode($rs));
        exit($rs['msg']);
    }
}
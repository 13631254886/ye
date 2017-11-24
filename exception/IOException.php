<?php
/*
 * 输入输出流异常
 */

namespace exception;


class IOException extends yException
{
    function __construct($code)
    {
        parent::__construct($code);
    }
}
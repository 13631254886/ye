<?php
/*
 * 数据库错误
 */

namespace exception;


class DbException extends yException
{
    function __construct($code)
    {
        parent::__construct($code);
    }
}
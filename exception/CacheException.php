<?php
/*
 * 缓存操作异常
 */

namespace exception;


class CacheException extends yException
{
    function __construct($code)
    {
        parent::__construct($code);
    }
}
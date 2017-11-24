<?php
/*
 * 文件无法找到
 */

namespace exception;


class ClassNotFoundException extends yException
{
    function __construct($code)
    {
        parent::__construct($code);
    }
}
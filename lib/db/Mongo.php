<?php
/*
 * Mongodb数据库驱动，可在此封装数据库操作
 */

namespace lib\db;


class Mongo implements IDb
{
    function connect(){}
    function hi()
    {
        print_r('hi,i am Mongo drive');
    }

}
<?php
/*
 * Oracle数据库驱动
 */

namespace lib\db;


class Oracle implements IDb
{

    public function connect()
    {
        // TODO: Implement connect() method.
    }

    public function hi()
    {
        print_r('hi,i am Oracle drive');
    }
}
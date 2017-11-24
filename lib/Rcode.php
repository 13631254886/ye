<?php
/*
 * 返回值类，便于api返回json格式数据
 */
namespace lib;

class Rcode
{
    public static $code = array(
        '0' => array('httpcode' => 200, 'msg' => 'ok'),
        '1' => array('httpcode' => 200, 'msg' => 'error'),

        //系统错误
        '1001' => array('httpcode' => 200, 'msg' => 'class is expected to use the namespace'),
        '1002' => array('httpcode' => 200, 'msg' => 'controller is not exist'),
        '1003' => array('httpcode' => 200, 'msg' => 'file missing'),

        //参数错误
        '2001' => array('httpcode' => 200, 'msg' => 'error param name'),
        '2002' => array('httpcode' => 200, 'msg' => 'error param type, request to be number'),
        '2003' => array('httpcode' => 200, 'msg' => 'error param type, request to be string'),
        '2004' => array('httpcode' => 200, 'msg' => 'error param type, request to be bool'),
        '2005' => array('httpcode' => 200, 'msg' => 'error param type'),

        //Url错误
        '3001' => array('httpcode' => 200, 'msg' => 'can not find this op'),

        //数据库错误
        '4001' => array('httpcode' => 200, 'msg' => 'database connect error'),
        '4002' => array('httpcode' => 200, 'msg' => 'please choose a table'),
        '4003' => array('httpcode' => 200, 'msg' => 'wrong sql'),

        //缓存错误
        '5001' => array('httpcode' => 200, 'msg' => 'can not connect to cache'),


    );

    public static function get($codeno, $data = null, $msg = null)
    {
        $rs = isset(self::$code[$codeno]) ? self::$code[$codeno] : null;
        $rsmsg = !is_null($rs) && isset($rs['msg']) ? $rs['msg'] : null;
        $httpcode = !is_null($rs) && isset($rs['httpcode']) ? $rs['httpcode'] : 200;
        if(200 != $httpcode) header($httpcode);

        $result['code'] = $codeno;
        $result['msg'] = $rsmsg;
        $result['data'] = $data;

        return $result;
    }
}
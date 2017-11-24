<?php
/*
 * 生成加密类型ID
 */

namespace lib;

use exception;
class Gens
{
    public $alg = array(
        'token' => 'md5',
    );

    /*
     * 选择算法
     */
    function Algorithm()
    {

    }

    /*
     * 生成不重复ID，将标识存入cookie，session，缓存或数据库
     */
    function genUniqid($type)
    {
        //判断生成id类型的加密算法是否存在
        if(!array_key_exists($type, $this->alg) || is_null($type))
            throw new exception\IOException(2005);

        //生成一个不重复ID，10000次并发内有效
        $time = TIME;
        $uniqid = hash($this->alg[$type], uniqid($type) . '-' . $time . rand(0, 10000));

        return $uniqid;
    }

    /*
     * 根据用户ID生成token
     */
    function genToken()
    {
        //获取用户openid
        $openid = getUser('openid');

        //根据当前时间生成token
        $token = hash('md5', 'token-'.$openid.'-'.TIME);

        return $token;
    }
}
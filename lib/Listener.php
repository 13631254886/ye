<?php
/*
 * 观察者类，当所监听的一个或多个函数触发某种动作时，
 * 执行相应的操作
 */

namespace lib;

class Listener
{
    public function __construct()
    {
    }

    /*
     * 返回结果检测
     * 当前方法组若首次出现return，无论在何处出现
     * 立刻停止接下来的函数操作
     * $funResult，当前函数执行后的结果
     */
    public static function listenReturn($funResult)
    {
        $return = null;
        //如果是多个函数
        if(is_array($funResult))
        {
            foreach ($funResult as $key => $f)
            {
                $return = $funResult[$key];
                if(!is_null($return)) break;
            }
        }
        else
            //如果是单个函数
            $return = $funResult;
        return $return;
    }

    /*
     * 错误异常检测
     */
    public static function listenError()
    {

    }

}
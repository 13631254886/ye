<?php
/*
 * 请求类，负责处理请求的内容
 * 控制器可以通过请求类来获取参数
 *
 * 进行Router功能分离
 */
namespace core;

use lib\Saver;
use exception;

class Request
{
    public static $instance;

    //请求类型
    public $method;

    //控制器
    public $controller;

    //方法
    public $action;

    //参数值
    public $param = array();

    //参数类型
    public $type = array();

    //请求者信息
    public $user = array();


    /*
     * 实例化Request请求时自动解析Uri请求
     */
    final protected function __construct()
    {
    }

    protected function requestMsg()
    {
        $this->user['ip'] = $_SERVER['REMOTE_ADDR'];
        $msg = $this->user['ip'].'-'.TIME.'-'.$this->method.'-'.$this->controller.'-'.$this->action;
        return $msg;
    }

    /*
     * 实例化单例类，静态模式确保整个请求阶段都能被调用
     */
    public static function ini()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new Request();
        }
        return self::$instance;
    }

    /*
     * 一个Request执行方法的流程
     * 获取参数，参数检测，控制器跳转
     * 进行请求类，路由类功能分离
     * 请求类：获取uri，ip等信息
     * 路由类：分离uri，绑定控制器及方法
     */
    public function exe()
    {
        $this->setParam();

        $this->checkParam();

        $response = $this->jumpUrl();

        return $response;
    }

    /*
     * 分离出uri中的不同参数并存入类中
     * 自动识别get或post请求
     *
     * 准备重写，支持多种uri解析写法。自动纠错功能
     */
    public function setParam()
    {
        //获取提交方式
        $this->method = strtoupper($_SERVER['REQUEST_METHOD']);

        //获取参数
        switch ($this->method)
        {
            case 'GET':$this->param = $_GET;break;
            case 'POST':$this->param = $_POST;break;
        }

        //获取操作名，没请求的话跳到index
        $name = trim(str_replace('/', '', $_SERVER['REDIRECT_URL'])) ? : Saver::fetch('config')['default_op'];

        //通过url截取路由表中对应的控制器和方法
        $url = isset(Saver::fetch('router')[$name]) ? Saver::fetch('router')[$name] : null;

        //若不存在该方法，则直接中断重新并返回错误。
        if(!$url) throw new exception\IOException(3001);

        //解析url
        $uri = explode(',', $url);

        $controllerAndAction = explode('/', $uri[0]);
        //获取控制器名称
        $this->controller = ucfirst($controllerAndAction[0]) ? : Saver::fetch('config')['default_controller'];//默认Index控制器
        $this->action = $controllerAndAction[1] ? : Saver::fetch('config')['default_action'];//默认index方法

        //去掉控制器和方法这段，剩下的都是参数
        unset($uri[0]);

        /*
         * 最后一次分离，参数和正则存入对应的属性数组中，下标相同的参数对应下标相同的正则
         * 如$this->param[1]参数的正则表达式为$this->type[1]
         */
        foreach ($uri as $key => $u)
        {
            $a = explode(':', $uri[$key]);
            $this->type = array_merge($this->type, array($a[0]=>$a[1]));
        }

        //记录日志
        Log::write($this->requestMsg(), 'request');
    }

    /*
     * 对参数进行正则处理,不存在的参数会被unset掉
     * 不符合类型的参数会被强制类型转换
     */
    public function checkParam()
    {
        foreach ($this->param as $key => $p)
        {
            //判断参数是否存在
            if(!array_key_exists($key, $this->type))
            {
                throw new exception\IOException(2001);//参数名错误
            }
            switch ($this->type[$key])
            {
                //若为数字型
                case 'd':
                    if(!is_numeric($this->param[$key]))
                        throw new exception\IOException(2005);//参数类型错误
                    break;
                //若为字符型
                case 's':
                    if(!is_string($this->param[$key]))
                        throw new exception\IOException(2005);//参数类型错误
                    break;
                //若为布尔型
                case 'b':
                    if(!is_bool($this->param[$key]))
                        throw new exception\IOException(2005);//参数类型错误
                    break;
            }
        }
    }

    /*
     * 跳转到指定的控制器
     */
    public function jumpUrl()
    {
        //定位命名空间
        $controller = 'app\controller\\'.$this->controller;
        $controllerUrl = ROOT_PATH.'controller\\'.$this->controller.'.php';
        //加载控制器文件
        if(file_exists($controllerUrl))
        {
            require $controllerUrl;
            $class = new $controller;
            //执行对应的action方法
            return call_user_func_array(array($class, $this->action), $this->param);
        }
        else
            throw new exception\ClassNotFoundException(1002);
    }

    /*
     * 获取经过处理的请求参数
     */
    public static function fetch($key = null)
    {
        if(is_null($key))
            return self::ini()->param;
        return isset(self::ini()->param[$key]) ? self::ini()->param[$key] : null;
    }

}
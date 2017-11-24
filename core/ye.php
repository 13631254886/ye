<?php
/*
 * ye框架核心文件
 */

use lib\Saver;
use core\Request;
use core\Log;
use core\Error;

class ye
{
    /*
     * 运行框架
     */
    function run()
    {
        //忽略该请求
        if('/favicon.ico' == $_SERVER['REQUEST_URI'])
            return;

        //注册自动加载类
        spl_autoload_register(array($this, 'autoload'));

        //加载配置文件
        $this->loadConfig();
        echo Saver::fetch('config')['app_mode'];
        //初始化渲染
        $this->render();

        //错误异常注册
        Error::register();

        //这里将整个控制器调用流程给集合了，返回的是控制器执行完后的结果
        $response = Request::ini()->exe();

        //如果有结果输出
        if(!is_null($response) && 'API' == APP_MODE)

        //将结果json序列化后输出
        echo json_encode($response);
    }

    /*
     * 实现了文件的自动加载机制
     * 解决了同名不同路径的类的问题
     * $class的格式是:命名空间\类名
     * 要求所有类都要使用命名空间
     */
    public static function autoload($class)
    {
        //判断文件是否存在
        if(file_exists($class.EXT)) {
            require $class . EXT;

            //Saver和Log的调用会漏掉，应为这两个在配置文件真正存入Saver前就执行完了
            Log::write($class . EXT, 'runtime');
        }
        else
            throw new exception\ClassNotFoundException(1003);
    }

    /*
     * 自动加载配置文件
     */
    function loadConfig()
    {
        //获取所有配置文件
        $allconfig = $this->getAllFiles(CONFIG_PATH);

        //利用foreach调用文件并将配置数组保存到Saver内
        foreach($allconfig as $key => $a)
        {
            Saver::save([basename($a, ".php") => require CONFIG_PATH.$a]);
        }
    }

    /*
     * 初始化渲染，这个功能需要修改
     */
    function render()
    {
        //设置时区
        date_default_timezone_set('PRC');

        //日志模式
        define('LOG_MODE', is_bool(Saver::fetch('config')['log_mode']) ? Saver::fetch('config')['log_mode'] : false);

        //应用模式
        define('APP_MODE', Saver::fetch('config')['app_mode']);
    }

    /*
     * 测试用函数，遍历类的对象
     * $class输入一个对象
     */
    function showProperty($class)
    {
        foreach($class as $key=>$val)
        {
            var_dump($val);
        }
    }

    /*
     * 获取指定目录下的所有文件名（带后缀）
     */
    function getAllFiles($path)
    {
        $allconfig = array_diff(scandir($path),array('..','.'));
        return $allconfig;
    }

}
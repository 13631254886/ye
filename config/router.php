<?php
/*
 * 路由器配置文件
 * 规则编写格式如下：
 * '操作名' => '控制器名/方法名,参数1名:参数1类型,参数2名:参数2类型……'
 * 其中，s：字符型  d：数字型  d：布尔型
 */
namespace config;

return $router = array(
    'index'   =>  'index/index,username:s,pwd:d',
    'test'    =>  'index/test,id:d',
);


<?php
namespace app\controller;

use core\Controller;
use core\Request;
use lib\cache\Memcache;
use lib\Db;
use lib\Cache;
use lib\Rcode;
use lib\Saver;

class Index extends Controller
{
    public function index()
    {
        $data = array(
            'a'=>1,
            'b'=>2,
            'c'=>3
        );
        return Rcode::get(0, $data);

    }
    public function test()
    {
//        $id = Request::fetch('id');
        //---------------数据库操作--------------------
//        $data = array('value'=>'1','value2'=>'111');
//        $rs = Db::getDb()->table('op')->insert($data)->execute();//增
//        $rs = Db::getDb()->table('op')->where('id < 100')->select('id,value')->order('id', 'asc')->limit(15)->execute();//查
//        $rs = Db::getDb()->table('op')->where('id < 100')->update($data)->execute();//改
//        $rs = Db::getDb()->table('op')->where('value = 1')->delete()->execute();//删

//        return $rs['data'];

//        Cache::getCache()->set('test','1234');
//        return Rcode::get(0,  Cache::getCache()->get('test'));


        //---------------缓存操作-----------------------
//        $rs = Cache::get('test');
//        if($rs) return Rcode::get(0, $rs);
        $rs = Db::getDb()->table('bigdata')->where('value = 15')->select('id,value')->order('id', 'asc')->execute();

        $rs = $rs->Rows();

//        Cache::set('test', $rs);

        return Rcode::get(0, $rs);


    }

}
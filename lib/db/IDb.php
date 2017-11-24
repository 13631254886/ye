<?php
/*
 * 数据库接口，规定了数据库操作方法名称
 * 以及一个完整的数据库驱动所需要实现的方法
 */
namespace lib\db;

interface IDb
{
    /*
     * 数据库连接
     */
    public function connect();

    /*
     * 插入数据
     */
    function insert($param);

    /*
     * 查找数据
     */
    function select($param);

    /*
     * 更新数据
     */
    function update($param);

    /*
     * 删除数据
     */
    function delete();

    /*
     * 条件
     */
    function where($where);

    /*
     * 排序
     */
    function order($param, $type);

    /*
     * 限制
     */
    function limit($param);

    /*
     * 联表
     */
    function join();

    /*
     * 获得表
     */
    function table($table);

    /*
     * 执行
     */
    function execute();

}
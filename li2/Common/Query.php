<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Query
 *
 * @author Administrator
 */
namespace Common;
class Query {

    private static function createObj() {
        $arr= \apps\Config::getInstance()->db;
        $dbtyle=  isset($arr['type']);
        return \core\db\DbMysqli::getInstance($arr['config']);
    }
    /**
     * 通过sql查询数据
     * @param type $sql
     * @return type
     */
    public static function sqlsel($sql){
        return self::createObj()->sqlsel($sql);
    }
    /**
     * 通过sql查询数据
     * @param type $sql
     * @return type
     */
    public static function sqlpage($sql,$page,$pagesize){
        return self::createObj()->sqlpage($sql,$page,$pagesize);
    }
    /**
     * 通过sql获得一条数据
     * @param type $sql
     * @return type
     */
    public static function sqlselone($sql){
        return self::createObj()->sqlselone($sql);
    }
    /**
     * 执行sql语句
     * @param type $sql
     * @return type
     */
    public static function sqlquery($sql){
        return self::createObj()->sqlquery($sql);
    }

    //put your code here
    /**
     * 查询数据
     * @param type $table
     * @param type $where
     * @param type $selarr
     * @param type $limit
     * @param type $group
     */
    public static function select($table, $where = array(), $selarr = array(), $order=array(),$limit = '', $group = '') {
        return self::createObj()->select($table, $where, $selarr, $order,$limit, $group);
    }
    /**
     * 分页读取数据
     * @param type $table
     * @param type $where
     * @param type $page
     * @param type $pagezize
     * @param type $selarr
     * @param type $order
     * @param type $limit
     * @param type $group
     * @return type
     */
    public static function pages($table, $where = array(), $page=1,$pagezize=20,$selarr = array(), $order=array(),$limit = '', $group = '') {
        return self::createObj()->selectpage($table, $where,$page,$pagezize,$selarr, $order,$limit, $group);
    }
    /**
     * 读取一条记录
     * @param type $table
     * @param type $where
     * @param type $selarr
     * @param type $order
     * @param type $group
     * @return type
     */
    public static function selone($table, $where = array(), $selarr = array(),$order=array(),$group = ''){
        return self::createObj()->selectone($table, $where, $selarr, $order,$group);
    }

    /**
     * 带缓存的查询
     * @param type $table
     * @param type $where
     * @param type $selarr
     * @param type $limit
     * @param type $group
     * @return type
     */
    public static function selcache($table, $where = array(), $selarr = array(), $limit = '', $group = '') {
        $key = $table . '_' . md5(json_encode($where) . json_encode($selarr) . $limit . $group);
        $val = App::caches($key);
        if ($val) {
            return $val;
        }
        $value = self::select($table, $where, $selarr, $limit, $group);
        App::caches($key, $value);
        return $value;
    }

    /**
     * 插入数据id
     */
    public static function insert_id() {
        return self::createObj()->insert_id();
    }

    /**
     * 插入数据
     * @param type $table
     * @param type $inarr
     * @param type $replace
     */
    public static function insert($table, $inarr, $replace = false) {
        return self::createObj()->insert($table, $inarr, $replace);
    }
    /**
     * 批量插入数据
     * @param type $table
     * @param type $inarr
     * @param type $replace
     */
    public static function inserts($table, $inarr, $replace = false) {
        return self::createObj()->inserts($table, $inarr, $replace);
    }

    /**
     * 更新数据
     * @param type $table
     * @param type $updarr
     * @param type $where
     * @param type $limit
     */
    public static function update($table, $updarr, $where = array(), $limit = '') {
        return self::createObj()->update($table, $updarr, $where, $limit);
    }

    /**
     * 删除数据
     * @param type $table
     * @param type $where
     * @param type $limit
     */
    public static function delete($table, $where = array(), $limit = '') {
        return self::createObj()->delete($table, $where, $limit);
    }
    /**
     * 开始数据库事物
     */
    public static function commitstart(){
        self::createObj()->commitstart();
    }
    /**
     * 提交事物
     * @return type
     */
    public static function commit(){
        return self::createObj()->commit();
    }
    /**
     * 事物回滚
     * @return type
     */
    public static function rollback(){
        return self::createObj()->rollback();
    }
    
 	 /**
     * 获取错误描述
     */
    public static function getError()
    {
        return self::createObj()->getError();
    }
}

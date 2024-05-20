<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Model\Sys;

use Common\Cache;
use Common\Query;

class Excel {
    /*
    $head = array('编号','姓名','年龄','出生年月');
    $data = array(
            array('001','zs',10,'1991-1-1'),
            array('002','李四',10,'1991-1-1'),
            array('003','王五',10,'1991-1-1'),
    );
    $obj->putCsv('putCsv.csv', $data, $head);
     */
    /**
     * [putCsv description]
     * @param  string  $csvFileName [description] 文件名
     * @param  array   $dataArr     [description] 数组，每组数据都是使用，分割的字符串
     * @param  string  $haderText   [description] 标题
     * @return [type]               [description]
     */
    public static function putCsv($csvFileName, $dataArr, $haderText = '') {
        $handle = fopen($csvFileName, "w"); //写方式打开
        if (!$handle) {
            return '文件打开失败';
        }
        //判断是否定义头标题
        if (!empty($haderText)) {
            foreach ($haderText as $key => $value) {
                $haderText[$key] = iconv("utf-8", "gbk//IGNORE", $value); //对中文编码进行处理
            }
            $re = fputcsv($handle, $haderText); //该函数返回写入字符串的长度。若出错，则返回 false。。
        }
        foreach ($dataArr as $key => $value) {
            foreach ($value as $k => $v) {
                $value[$k] = iconv("utf-8", "gbk//IGNORE", $v); //对中文编码进行处理
            }
            $re = fputcsv($handle, $value); //该函数返回写入字符串的长度。若出错，则返回 false。。
        }
        return $re;
    }

    /**
     * [getCsv description]  导出csv文件
     * @param  string  $csvFileName [description] 文件名
     * @param  integer $line        [description] 读取几行，默认全部读取
     * @param  integer $offset      [description] 从第几行开始读，默认从第一行读取
     * @return [type]               [description]
     */
    public function getCsv($csvFileName, $line = 0, $offset = 0) {
        $handle = fopen($csvFileName, 'r'); //打开文件，如果打开失败，本函数返回 FALSE。
        if (!$handle) {
            return '文件打开失败';
        }
        //fgetcsv() 出错时返回 FALSE，包括碰到文件结束时。
        $i = 0; //用于记录while的循环次数，方便与$line,$offset比较
        $arr = array(); //结果的存放数组
        while ($data = fgetcsv($handle)) {
            //小于偏移量则不读取,但$i仍然需要自增
            if ($i < $offset && $offset) {
                $i++;
                continue;
            }
            //大于读取行数则退出
            if ($i > $line && $line) {
                break;
            }
            $i++;
            foreach ($data as $key => $value) {
                $content = iconv("gbk", "utf-8//IGNORE", $value); //转化编码
                $arr[] = $content; //至于如何处理这个结果，需要根据实际情况而定
            }
        }
        return $arr;
    }
}


<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of View
 *
 * @author Administrator
 */
namespace core;
class View extends \ArrayObject {

    //put your code here
    protected $path;

    public function __construct($array = array()) {
        ob_start();
        parent::__construct($array, \ArrayObject::ARRAY_AS_PROPS);
    }

    public function setPath() {
        
    }

    
    /**
     * 加载模板文件
     * @param type $file
     * @return type
     */
    public function render($file) {
        if(!empty($this->tVar)){
            extract($this->tVar);
        }
        $filename =  Template::getInstance()->template($file);
        include $filename;
        return ob_get_clean();
    }

    /**
     * 获取数组的值
     * @param type $arr
     * @param type $keyarr
     * @return type 
     */
    public function getArrayValue($arr, $keyarr) {
        foreach ($keyarr as $v) {
            if (!array_key_exists($v, $arr)) {
                return '';
            }
            $arr = $arr[$v];
        }
        return $arr;
    }
    /**
     * 现实时间
     * @param type $dateLine
     * @return string
     */
    protected function showTimes($dateLine) {
        $nowtimed = time() - $dateLine;
        if ($nowtimed < 60)
            return $nowtimed . '秒前';
        if ($nowtimed < 360)
            return intval($nowtimed / 60) . '分钟前';
        if ($nowtimed < 86400)
            return intval($nowtimed / 360) . '小时前';
        if ($nowtimed < 172800)
            return '昨天';
        if ($nowtimed < 259200)
            return '前天';
        return date('Y-m-d', $dateLine);
    }
    /**
     * 字符截取
     * @param type $str
     * @param type $length
     * @param type $start
     * @return string
     */
    protected function substr($str, $length, $start = 0) {
        $str=trim($str);
        if (strlen($str) < $start + 1) {
            return '';
        }
        preg_match_all("/./su", $str, $ar);
        $str = '';
        $tstr = '';
        for ($i = 0; isset($ar[0][$i]); $i++) {
            if (strlen($tstr) < $start) {
                $tstr .= $ar[0][$i];
            } else {
                if (strlen($str) < $length + strlen($ar[0][$i])) {
                    $str .= $ar[0][$i];
                } else {
                    break;
                }
            }
        }
        return $str;
    }
    /**
     * 去除html
     * @param type $str
     * @return type
     */
    protected function trimhtml($str) {
        $str = preg_replace('/<.+>/msU', '', $str);
        $str = str_replace('&nbsp;', '', $str);
        return $str;
    }
    /**
     * 获取数组的值
     * @param type $arr
     * @param type $key
     * @return string
     */
    protected function getArrayKey($arr,$key){
        if(isset($arr[$key])){
            return $arr[$key];
        }
        else{
            return '';
        }
    }

}

?>

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Url
 *
 * @author Administrator
 */

namespace core\net;

class Url {

    //put your code here
    static $_instance;
    private $rewrite;

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct() {
        $this->rewrite = 0;
    }

    /**
     * 过滤字符
     *
     * @param String $string
     * @return String
     */
    private function xss($string) {
        if (is_array($string)) {
            foreach ($string as $key => $val) {
                if (substr($key, 0, 7) == '_jscon_') {
                    $key = str_replace('_jscon_', '', $key);
                    $string[$key] = $val;
                } else {
                    $string[$key] = self::xss($val);
                }
            }
        } else {
            $string = htmlentities($string,ENT_QUOTES,'UTF-8');//htmlentities($string);
//            $string = rawurldecode($string);
//            $string = str_replace('../', '', $string);//
//            
//            $string = str_replace('\'', '&prime;', $string);
//            $sql = array("load_file", "outfile");
//            $sql_re = array("l&shy;oad_file", "o&shy;utfile");
//            $string=str_replace($sql, $sql_re, $string);
            $string = preg_replace('/select.+?from/i', '', $string);//防止输入整条sql
        }
        return $string;
    }

    public function dataFilters() {
        $this->getParams();
        $_GET = $this->xss($_GET);
        $_POST = $this->xss($_POST);
        $_COOKIE = $this->xss($_COOKIE);
        $this->getApp();
        $this->getController();
        $this->getAction();
    }

    private function getParams() {
        if (!$this->rewrite) {
            return;
        }
        $request = trim($_SERVER['REQUEST_URI']);
        if (substr($request, 0, 11) == '/index.php?') {
            return 0;
        }
        if (substr($request, 0, 2) == '/?') {
            return 0;
        }
        $request = str_replace(FILEEXT, '', $request);
        $request = str_replace('?ajax=1', '', $request);
        $splits = explode('-', $request);
        $splits[0] = str_replace('/', '', $splits[0]);
        if ($splits[0] && $splits[0] != 'ac') {
            $_GET['mod'] = $splits[0];
        } else {
            $_GET['mod'] = 'index';
        }
        $len = count($splits);
        $start = $splits[0] == 'ac' ? 0 : 1;
        for ($i = $start; $i < $len; $i++) {
            $key = $splits[$i];
            $i++;
            if (array_key_exists($i, $splits))
                $_GET[$key] = $splits[$i];
        }
    }

    public function rewriteUrl($body) {
        if (!$this->rewrite) {
            return $body;
        }
        $pattern = '/([\'\"]?)\/index\.php\?(.*)\1/imU';
        if (preg_match_all($pattern, $body, $matches)) {
            $arrays = array();
            foreach ($matches[2] as $k => $pArr) {
                $str = str_replace(array('=', '&', 'mod-'), array('-', '-', ''), $pArr);
                $arrays[0][$k] = '"' . $str . FILEEXT . '"';
            }
            return str_replace($matches[0], $arrays[0], $body);
        }
        return $body;
    }

    private function getApp() {
        $app = isset($_GET['app']) ? trim(htmlentities($_GET['app'])) : 'web';
        \App::set('currentapp', $app);
        \App::set('currentapppath', APP_PATH . $app . DIRECTORY_SEPARATOR);
    }

    private function getController() {
        $controller = isset($_GET['mod']) ? trim(htmlentities($_GET['mod'])) : 'index';
        \App::set('currentcontroller', $controller);
        \App::set('templateapppath', APP_PATH . \App::get('currentapp') . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . $controller . DIRECTORY_SEPARATOR);
    }

    private function getAction() {
        $value = isset($_GET['ac']) ? trim(htmlentities($_GET['ac'])) : 'view';
        \App::set('currentactions', $value);
    }

}

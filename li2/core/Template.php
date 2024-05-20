<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Template
 *
 * @author Administrator
 */
namespace core;
class Template {
    //put your code here
    static $_instance;
    private $cache=0;
    private $cachepath='';
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    public function __construct() {
        $config= \apps\Config::getInstance()->tempt;
        $this->cache=  intval($config['cache']);
        $this->cachepath= isset($config['cachepath'])?trim($config['cachepath']):'';
    }
    private function parsefile($file){
        $template = $this->getCons($file);
        $template = preg_replace_callback('/<!--include\sfile\s"(.+)"-->/imU', function ($matches) {
            $file= Template::getInstance()->getFilepath($matches[1]);
            return Template::getInstance()->getCons($file);},$template);
        $template= net\Url::getInstance()->rewriteUrl($template); 
        return $template;

    }

    public function getCons($file) {
        if (file_exists($file)) {
            return file_get_contents($file);
        } else {
           return '';
        }
        //return ob_get_clean();
    }

    private function getcfile($file){
        $cachefile1=  str_replace(APP_PATH, '', $file);
        $cachefile1= str_replace(DIRECTORY_SEPARATOR,'-', $cachefile1);
        $cachefile1= str_replace('/','-', $cachefile1);
        $cachefile=  $this->cachepath.DIRECTORY_SEPARATOR.$cachefile1;
        if(file_exists($cachefile)&&$this->cache){
            return $cachefile;
        }
        $con=  $this->parsefile($file);
        file_put_contents($cachefile, $con);
        return $cachefile;
    }

    public function template($file){
        $tfile=  $this->getFilepath($file);
        $cachefile=  $this->getcfile($tfile);
        if(!file_exists($cachefile)){
            $this->parsefile($tfile,$cachefile);
        }
        return $cachefile;
    }
    public function getFilepath($file){
        $paths = \App::get('templateapppath');
        $tfile=$paths.$file;
        if(!file_exists($tfile)){
            $tfile = realpath(\App::get('templateapppath').'..'.DIRECTORY_SEPARATOR.$file);
        }
        if(!file_exists($tfile)){
            throw new \Exception($file.'文件不存在');
        }
        return $tfile;
    }
}

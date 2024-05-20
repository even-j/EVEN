<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of File
 *
 * @author Administrator
 */
namespace core\io;
class Files {

    //put your code here
    public static function upload($name) {
        $f=$_FILES[$name];
        if ($f["error"] > 0) {
            return '';
        } else {
            $extarr=  explode('.', $f["name"]);
            $ext=  end($extarr);
            $savepath=ROOT.'/upload';
            if(!is_dir($savepath)){
                mkdir($savepath, 0777);
            }
            $savepath=$savepath.'/'.date('Ym',time());
            if(!is_dir($savepath)){
                mkdir($savepath, 0777);
            }
            $file=$savepath.'/'.time().'.'.$ext;
            if(move_uploaded_file($f["tmp_name"], $file)){
                return str_replace(ROOT, '', $path);
            }
            return '';
        }
    }
    public static function txt($cons,$path){
        
    }

}

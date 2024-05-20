<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace core\secure;

/**
 * 用文件锁来做原子锁定
 *
 * @author Administrator
 */
class Lock {
    /**
     * 锁定
     * @param type $id
     * @return type
     */
    public static function lock($id) {
        $file = fopen("/tmp/lock" . $id, "w+");
        return flock($file, LOCK_EX);
    }
    /**
     * 解锁
     * @param type $id
     * @return type
     */
    public static function unlock($id) {
        if (file_exists("/tmp/lock" . $id)) {
            $file = fopen("/tmp/lock" . $id, "w+");
            return flock($file, LOCK_UN);
        }
    }

}

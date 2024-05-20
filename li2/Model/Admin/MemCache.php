<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model\Admin;

/**
 * Description of Cache
 *
 * @author Admin
 */
class MemCache {

    //put your code here
    public static function getkey($page = 1, $num = 20, $key = '') {
        $keylist = \Common\Cache::getallkey();
        if (!is_array($keylist) || empty($keylist)) {
            return array('num' => 0, 'data' => array());
        }
        $rsnum = 0;
        $dataarr = array();
        $startnum = ($page - 1) * $num;
        if ($startnum < 0)
            $startnum = 0;
        foreach ($keylist as $value) {
            if ($key != '') {
                if (!stristr($value, $key)) {
                    continue;
                }
            }
            $rsnum++;
            if ($rsnum > $startnum && $rsnum <= ($startnum + $num)) {
                $dataarr[$rsnum]['key'] = $value;
                $dataarr[$rsnum]['value'] = \Common\Cache::get($value);
            }
        }

        return array('num' => $rsnum, 'data' => $dataarr);
    }

}

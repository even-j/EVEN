<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace apps\admin;

/**
 * Description of memcache
 *
 * @author fjlh
 */
class memcache extends \apps\AdminControl {
    //put your code here
    public function view() {
        parent::view();
        $this->setTitle ( '清除缓存' );
        $page = isset($_GET['page'])?intval($_GET['page']):1;
        $num = 20;
        $key = isset($_GET['key'])?trim($_GET['key']):'';
        $d=\Model\Admin\MemCache::getkey($page, $num, $key);
        $pager=\Common\Pager::getPageList($page,$d['num'],$num);
        $this->assign('listdata',$d['data']);
        $this->assign('pager', $pager);
        $this->template('index.php');
    }
    public function del(){
        $key = isset($_GET['key'])?trim($_GET['key']):'';
        if($key!=''){
            \Common\Cache::rm($key);
        }
        $this->sysRedirect($_SERVER["HTTP_REFERER"]);
    }
}

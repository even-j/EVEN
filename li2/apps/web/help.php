<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of index
 *
 * @author Administrator
 */

namespace apps\web;

class help extends \core\Controller {

    //put your code here
    public function guide() {
        $this->setTitle('新手指南' . '-' . SITE_TITLE);
        $this->template('guide.php');
    }

    public function member() {
        $this->setTitle('常见问题' . '-' . SITE_TITLE);
        $where = ' WHERE pid=7';
        $selarr = array('`id`', '`title`','contents', '`addtime`');
        $order = ' ORDER BY `addtime`';
        $list = \Common\Pager::getList('article', $where, $selarr, $order, 1, 1000);
        $this->assign('list', $list['data']);
        $this->template('member.php');
    }

    public function storck() {
        $this->setTitle('策略相关' . '-' . SITE_TITLE);
        $this->template('storck.php');
    }

    public function safety() {
        $this->setTitle('安全保障' . '-' . SITE_TITLE);
        $this->template('safety.php');
    }

    public function agreement() {
        $this->setTitle('注册协议' . '-' . SITE_TITLE);
        $this->template('agreement.php');
    }

    public function software() {
        $this->setTitle('APP下载' . '-' . SITE_TITLE);
        $this->template('software.php');
    }
    
    public function tradeapp() {
        $this->setTitle('交易软件' . '-' . SITE_TITLE);
        $this->template('tradeapp.php');
    }

    public function contract() {
        $this->setTitle('贷款协议' . '-' . SITE_TITLE);
        $pz_id = intval($_GET['pz_id']);
        $pz_row = \Model\Peizi\Peizi::getById($pz_id, $this->uid);
        $this->assign('pz_row', $pz_row);
        $this->assign('user', $this->user);
        $this->template('contract.php');
    }

}

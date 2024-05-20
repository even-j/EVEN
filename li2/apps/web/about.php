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

class about extends \core\Controller {

    //put your code here
    public function us() {
        $this->setTitle('公司简介' . '-' . SITE_TITLE);
        $this->template('us.php');
    }

    public function qualification() {
        $this->setTitle('证件荣誉' . '-' . SITE_TITLE);
        $this->template('qualification.php');
    }

    public function office() {
        $this->setTitle('人才招聘' . '-' . SITE_TITLE);
        $this->template('office.php');
    }

    public function job() {
        $this->setTitle('人才招聘' . '-' . SITE_TITLE);
        $this->template('job.php');
    }

    public function contact() {
        $this->setTitle('联系我们' . '-' . SITE_TITLE);
        $this->template('contact.php');
    }

}

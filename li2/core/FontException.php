<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FontException
 *
 * @author Administrator
 */

namespace core;

class FontException extends \Exception {

    //put your code here
    public function __construct($message, $code, $previous = NULL) {
        parent::__construct($message, $code, $previous);
        @header("http/1.1 404 not found");
        @header("status: 404 not found");
        echo $message;
        exit();
        $this->shows();
    }

    private function shows() {
        echo $this->__toString();
    }

}

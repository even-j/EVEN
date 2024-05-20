<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Socket
 *
 * @author Administrator
 */

namespace core\net;

class Socket {

    //put your code here
    function PostToHost($url, $data) {
        $url = parse_url($url);
        if (!$url) {
            return "couldn't parse url";
        }
        if (!isset($url['port'])) {
            $url['port'] = "";
        }
        if (!isset($url['query'])) {
            $url['query'] = "";
        }
        $encoded = "";
        while (list($k, $v) = each($data)) {
            $encoded .= ($encoded ? "&" : "");
            $encoded .= rawurlencode($k) . "=" . rawurlencode($v);
        }
        $port = $url['port'] ? $url['port'] : 80;
        $fp = fsockopen($url['host'], $port, $errno, $errstr);
        if (!$fp) {
            return "Failed to open socket to $url[host] $port ERROR: $errno - $errstr";
        }
        fputs($fp, sprintf("POST %s%s%s HTTP/1.0\n", $url['path'], $url['query'] ? "?" : "", $url['query']));
        fputs($fp, "Host: $url[host]\n");
        fputs($fp, "Content-type: application/x-www-form-urlencoded\n");
        fputs($fp, "Content-length: " . strlen($encoded) . "\n");
        fputs($fp, "Connection: close\n\n");

        fputs($fp, "$encoded\n");

        $line = fgets($fp, 1024);
        if (!eregi("^HTTP/1\.. 200", $line)) {
            return;
        }
        $results = "";
        $inheader = 1;
        while (!feof($fp)) {
            $line = fgets($fp, 1024);
            if ($inheader && ($line == "\n" || $line == "\r\n")) {
                $inheader = 0;
            } elseif (!$inheader) {
                $results .= $line;
            }
        }
        fclose($fp);

        return $results;
    }

}

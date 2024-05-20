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

namespace apps\wap;

class peiziu extends \apps\UserControl {

    //put your code here
    public function peizi() {
        $money = isset($_GET ['money']) ? floatval($_GET ['money']) : 0;
        $pz_ratio = isset($_GET ['pz_ratio']) ? intval($_GET ['pz_ratio']) : 5;
        $pz_type = isset($_GET ['pz_type']) ? intval($_GET ['pz_type']) : 1;
        $title = '';
        if ($pz_type == 1) {
            $title = '按天配资';
        } elseif ($pz_type == 2) {
            $title = '按月配资';
        } elseif ($pz_type == 4) {
            $title = '免费体验';
        }
        $this->setTitle($title . '—' . SITE_TITLE);
        $error_msg = '';
        if (!\Model\User\UserInfo::checkBindInfo($this->uid)) {
            //$this->fontRedirect('实名身份信息未绑定，请先绑定实名信息', \App::URL('web/user/account'),3);
            $error_msg = '实名身份信息未绑定，请先绑定实名信息 <a href="' . \App::URL('wap/user/account') . '" style="font-size:14px;color:blue">绑定实名</a>';
        }

        if ($pz_type == 1 && $money == 0) {
            $error_msg = '参数错误';

            //$this->fontRedirect('参数错误', \App::URL('web/peizi/daywin1'));
        }
        if ($pz_type == 4) { //免费体验
            $row_tmp = \Common\Query::select('user_peizi', array('uid' => $this->uid, 'pz_type' => 4));
            if ($row_tmp) {
                $error_msg = '您已经免费体验过，不能再次体验!';
            }
        }
        if ($pz_type == 1) {
            $params = \Model\Admin\Params::get('peizi');
            $var ['pz_type'] = $pz_type;
            $var ['pz_money'] = $money;
            $var ['pz_ratio'] = $pz_ratio;
            $var ['manage_cost_day'] = floatval($params ['manage_cost_money' . $pz_ratio]) / 100; //每天
            $var ['bond'] = intval($money / $params ['pz_ratio' . $pz_ratio]);
            $var ['manage_cost_money'] = ($money / 10000) * $var ['manage_cost_day'] * 2; //默认2天
            $var ['pay_total'] = $var ['bond'] + $var ['manage_cost_money'];
        } elseif ($pz_type == 2 || $pz_type == 7) {
            $params = \Model\Admin\Params::get('peizi_month');
            $var ['pz_type'] = $pz_type;
            $var ['pz_money'] = $money;
            $var ['pz_ratio'] = $pz_ratio;
            $var ['manage_cost_day'] = $var ['pz_money'] * floatval($params ['manage_cost_money' . $pz_ratio]) / 100;
            $var ['bond'] = $money / (1 + $pz_ratio);
            $var ['manage_cost_money'] = $var ['manage_cost_day'];
            $var ['pay_total'] = $var ['bond'] + $var ['manage_cost_money'];
        } elseif ($pz_type == 4) {
            $params = \Model\Admin\Params::get('peizi_free');
            $var ['pz_type'] = $pz_type;
            $var ['pz_money'] = $params ['service_cost_rate'];
            $var ['pz_ratio'] = 0;
            $var ['manage_cost_day'] = $params ['manage_cost_money']; //每天
            $var ['bond'] = $params ['baozheng_free'];
            $var ['manage_cost_money'] = $var ['manage_cost_day'] * $params ['free_day'];
            $var ['pay_total'] = $var ['bond'] + $var ['manage_cost_money'];
        }
        $this->assign('var', $var);
        $this->assign('error_msg', $error_msg);
        $this->assign('params', $params);
        $this->assign('user', $this->user);
        $this->template('peizi.php');
    }
}

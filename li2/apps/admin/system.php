<?php

namespace apps\admin;

class system extends \apps\AdminControl {

    //put your code here
    public function view() {
        $this->setTitle('系统管理');
        $params_site_base = \Model\Admin\Params::get('site_base');
        $params_site_sms = \Model\Admin\Params::get('site_sms');
        $params_site_pay = \Model\Admin\Params::get('site_pay');

        $type = isset($_GET ['type']) ? intval($_GET ['type']) : 1;

        $navList = array(array('id' => 1, 'name' => '网站基本设置'), array('id' => 2, 'name' => '支付接口设置'), array('id' => 3, 'name' => '短信接口设置'));

        $this->assign('type', $type);
        $this->assign('navList', $navList);
        $this->assign('site_base', $params_site_base);
        $this->assign('site_sms', $params_site_sms);
        $this->assign('site_pay', $params_site_pay);
        $this->template('index.php');
    }

    //参数设置
    public function params() {
        $this->setTitle('参数设置');
        $type = isset($_GET ['type']) ? intval($_GET ['type']) : 1;

        $peizi = \Common\Query::selone('admin_params', array('ckey' => 'peizi'));
        $params_peizi = unserialize($peizi ['cvalue']);

        $p2p = \Common\Query::selone('admin_params', array('ckey' => 'p2p'));
        $params_p2p = unserialize($p2p ['cvalue']);

        $peizi_free = \Common\Query::selone('admin_params', array('ckey' => 'peizi_free'));
        $params_peizi_free = unserialize($peizi_free ['cvalue']);
        $params_peizi_month = \Model\Admin\Params::get('peizi_month');
        $params_peizi_qihuo = \Model\Admin\Params::get('peizi_qihuo');

        $navList = array(array('id' => 1, 'name' => '按天配资参数设置'), array('id' => 3, 'name' => '免费配资参数设置'), array('id' => 4, 'name' => '按月配资参数设置'));

        $this->assign('type', $type);
        $this->assign('navList', $navList);
        $this->assign('peizi', $params_peizi);
        $this->assign('p2p', $params_p2p);
        $this->assign('peizi_free', $params_peizi_free);
        $this->assign('peizi_month', $params_peizi_month);
        $this->assign('peizi_qihuo', $params_peizi_qihuo);

        $this->template('params.php');
    }

    //配资数据更新
    public function doPeizi() {
        if ($_POST) {
            $data ['pz_ratio1'] = isset($_POST ['pz_ratio1']) ? intval($_POST ['pz_ratio1']) : 1;
            $data ['pz_ratio2'] = isset($_POST ['pz_ratio2']) ? intval($_POST ['pz_ratio2']) : 2;
            $data ['pz_ratio3'] = isset($_POST ['pz_ratio3']) ? intval($_POST ['pz_ratio3']) : 3;
            $data ['pz_ratio4'] = isset($_POST ['pz_ratio4']) ? intval($_POST ['pz_ratio4']) : 4;
            $data ['pz_ratio5'] = isset($_POST ['pz_ratio5']) ? intval($_POST ['pz_ratio5']) : 5;
            $data ['pz_ratio6'] = isset($_POST ['pz_ratio6']) ? intval($_POST ['pz_ratio6']) : 6;
            $data ['pz_ratio7'] = isset($_POST ['pz_ratio7']) ? intval($_POST ['pz_ratio7']) : 7;
            $data ['pz_ratio8'] = isset($_POST ['pz_ratio8']) ? intval($_POST ['pz_ratio8']) : 8;
            $data ['pz_ratio9'] = isset($_POST ['pz_ratio9']) ? intval($_POST ['pz_ratio9']) : 9;
            $data ['pz_ratio10'] = isset($_POST ['pz_ratio10']) ? intval($_POST ['pz_ratio10']) : 10;

            $data ['alarm_rate1'] = isset($_POST ['alarm_rate1']) ? floatval($_POST ['alarm_rate1']) : 15;
            $data ['alarm_rate2'] = isset($_POST ['alarm_rate2']) ? floatval($_POST ['alarm_rate2']) : 20;
            $data ['alarm_rate3'] = isset($_POST ['alarm_rate3']) ? floatval($_POST ['alarm_rate3']) : 25;
            $data ['alarm_rate4'] = isset($_POST ['alarm_rate4']) ? floatval($_POST ['alarm_rate4']) : 30;
            $data ['alarm_rate5'] = isset($_POST ['alarm_rate5']) ? floatval($_POST ['alarm_rate5']) : 35;
            $data ['alarm_rate6'] = isset($_POST ['alarm_rate6']) ? floatval($_POST ['alarm_rate6']) : 40;
            $data ['alarm_rate7'] = isset($_POST ['alarm_rate7']) ? floatval($_POST ['alarm_rate7']) : 45;
            $data ['alarm_rate8'] = isset($_POST ['alarm_rate8']) ? floatval($_POST ['alarm_rate8']) : 50;
            $data ['alarm_rate9'] = isset($_POST ['alarm_rate9']) ? floatval($_POST ['alarm_rate9']) : 55;
            $data ['alarm_rate10'] = isset($_POST ['alarm_rate10']) ? floatval($_POST ['alarm_rate10']) : 60;

            $data ['stop_rate1'] = isset($_POST ['stop_rate1']) ? floatval($_POST ['stop_rate1']) : 13;
            $data ['stop_rate2'] = isset($_POST ['stop_rate2']) ? floatval($_POST ['stop_rate2']) : 18;
            $data ['stop_rate3'] = isset($_POST ['stop_rate3']) ? floatval($_POST ['stop_rate3']) : 23;
            $data ['stop_rate4'] = isset($_POST ['stop_rate4']) ? floatval($_POST ['stop_rate4']) : 28;
            $data ['stop_rate5'] = isset($_POST ['stop_rate5']) ? floatval($_POST ['stop_rate5']) : 33;
            $data ['stop_rate6'] = isset($_POST ['stop_rate6']) ? floatval($_POST ['stop_rate6']) : 38;
            $data ['stop_rate7'] = isset($_POST ['stop_rate7']) ? floatval($_POST ['stop_rate7']) : 43;
            $data ['stop_rate8'] = isset($_POST ['stop_rate8']) ? floatval($_POST ['stop_rate8']) : 48;
            $data ['stop_rate9'] = isset($_POST ['stop_rate9']) ? floatval($_POST ['stop_rate9']) : 53;
            $data ['stop_rate10'] = isset($_POST ['stop_rate10']) ? floatval($_POST ['stop_rate10']) : 58;

            $data ['manage_cost_money1'] = isset($_POST ['manage_cost_money1']) ? floatval($_POST ['manage_cost_money1']) : 0.1;
            $data ['manage_cost_money2'] = isset($_POST ['manage_cost_money2']) ? floatval($_POST ['manage_cost_money2']) : 0.1;
            $data ['manage_cost_money3'] = isset($_POST ['manage_cost_money3']) ? floatval($_POST ['manage_cost_money3']) : 0.1;
            $data ['manage_cost_money4'] = isset($_POST ['manage_cost_money4']) ? floatval($_POST ['manage_cost_money4']) : 0.1;
            $data ['manage_cost_money5'] = isset($_POST ['manage_cost_money5']) ? floatval($_POST ['manage_cost_money5']) : 0.1;
            $data ['manage_cost_money6'] = isset($_POST ['manage_cost_money6']) ? floatval($_POST ['manage_cost_money6']) : 0.1;
            $data ['manage_cost_money7'] = isset($_POST ['manage_cost_money7']) ? floatval($_POST ['manage_cost_money7']) : 0.1;
            $data ['manage_cost_money8'] = isset($_POST ['manage_cost_money8']) ? floatval($_POST ['manage_cost_money8']) : 0.1;
            $data ['manage_cost_money9'] = isset($_POST ['manage_cost_money9']) ? floatval($_POST ['manage_cost_money9']) : 0.1;
            $data ['manage_cost_money10'] = isset($_POST ['manage_cost_money10']) ? floatval($_POST ['manage_cost_money10']) : 0.1;

            $data ['minLimitMoney'] = isset($_POST ['minLimitMoney']) ? floatval($_POST ['minLimitMoney']) * 100 : 1000000;
            $data ['maxLimitMoney'] = isset($_POST ['maxLimitMoney']) ? floatval($_POST ['maxLimitMoney']) * 100 : 30000000;
            //$data ['maxLimitRatio'] = isset ( $_POST ['maxLimitRatio'] ) ? intval ( $_POST ['maxLimitRatio'] ) : 10;
            //$data ['maxLimitTimes'] = isset ( $_POST ['maxLimitTimes'] ) ? intval ( $_POST ['maxLimitTimes'] ) : 30;

            $res = \Model\Admin\Params::save('peizi', $data);
            $msg = $res ? '设置成功' : '设置失败';
            $this->fontRedirect($msg, '/index.php?app=admin&mod=system&ac=params');
        }
    }

    //P2P参数数据更新
    public function doP2P() {
        if ($_POST) {
            $data ['peizi_max'] = isset($_POST ['peizi_max']) ? floatval($_POST ['peizi_max']) : 2000;
            $data ['service_cost_rate1'] = isset($_POST ['service_cost_rate1']) ? floatval($_POST ['service_cost_rate1']) : 1;
            $data ['service_cost_rate2'] = isset($_POST ['service_cost_rate2']) ? floatval($_POST ['service_cost_rate2']) : 1;
            $data ['service_cost_rate3'] = isset($_POST ['service_cost_rate3']) ? floatval($_POST ['service_cost_rate3']) : 1;
            $data ['service_cost_rate4'] = isset($_POST ['service_cost_rate4']) ? floatval($_POST ['service_cost_rate4']) : 1;
            $data ['service_cost_rate5'] = isset($_POST ['service_cost_rate5']) ? floatval($_POST ['service_cost_rate5']) : 1;
            $data ['service_cost_rate6'] = isset($_POST ['service_cost_rate6']) ? floatval($_POST ['service_cost_rate6']) : 1;
            $data ['service_cost_rate7'] = isset($_POST ['service_cost_rate7']) ? floatval($_POST ['service_cost_rate7']) : 1;
            $data ['service_cost_rate8'] = isset($_POST ['service_cost_rate8']) ? floatval($_POST ['service_cost_rate8']) : 1;
            $data ['service_cost_rate9'] = isset($_POST ['service_cost_rate9']) ? floatval($_POST ['service_cost_rate9']) : 1;
            $data ['service_cost_rate10'] = isset($_POST ['service_cost_rate10']) ? floatval($_POST ['service_cost_rate10']) : 1;
            $data ['alarm_rate1'] = isset($_POST ['alarm_rate1']) ? floatval($_POST ['alarm_rate1']) : 50;
            $data ['alarm_rate2'] = isset($_POST ['alarm_rate2']) ? floatval($_POST ['alarm_rate2']) : 50;
            $data ['alarm_rate3'] = isset($_POST ['alarm_rate3']) ? floatval($_POST ['alarm_rate3']) : 50;
            $data ['alarm_rate4'] = isset($_POST ['alarm_rate4']) ? floatval($_POST ['alarm_rate4']) : 50;
            $data ['alarm_rate5'] = isset($_POST ['alarm_rate5']) ? floatval($_POST ['alarm_rate5']) : 50;
            $data ['alarm_rate6'] = isset($_POST ['alarm_rate6']) ? floatval($_POST ['alarm_rate6']) : 50;
            $data ['alarm_rate7'] = isset($_POST ['alarm_rate7']) ? floatval($_POST ['alarm_rate7']) : 50;
            $data ['alarm_rate8'] = isset($_POST ['alarm_rate8']) ? floatval($_POST ['alarm_rate8']) : 50;
            $data ['alarm_rate9'] = isset($_POST ['alarm_rate9']) ? floatval($_POST ['alarm_rate9']) : 50;
            $data ['alarm_rate10'] = isset($_POST ['alarm_rate10']) ? floatval($_POST ['alarm_rate10']) : 50;
            $data ['stop_rate1'] = isset($_POST ['stop_rate1']) ? floatval($_POST ['stop_rate1']) : 40;
            $data ['stop_rate2'] = isset($_POST ['stop_rate2']) ? floatval($_POST ['stop_rate2']) : 40;
            $data ['stop_rate3'] = isset($_POST ['stop_rate3']) ? floatval($_POST ['stop_rate3']) : 40;
            $data ['stop_rate4'] = isset($_POST ['stop_rate4']) ? floatval($_POST ['stop_rate4']) : 40;
            $data ['stop_rate5'] = isset($_POST ['stop_rate5']) ? floatval($_POST ['stop_rate5']) : 40;
            $data ['stop_rate6'] = isset($_POST ['stop_rate6']) ? floatval($_POST ['stop_rate6']) : 40;
            $data ['stop_rate7'] = isset($_POST ['stop_rate7']) ? floatval($_POST ['stop_rate7']) : 40;
            $data ['stop_rate8'] = isset($_POST ['stop_rate8']) ? floatval($_POST ['stop_rate8']) : 40;
            $data ['stop_rate9'] = isset($_POST ['stop_rate9']) ? floatval($_POST ['stop_rate9']) : 40;
            $data ['stop_rate10'] = isset($_POST ['stop_rate10']) ? floatval($_POST ['stop_rate10']) : 40;
            $data ['limit_days'] = isset($_POST ['limit_days']) ? floatval($_POST ['limit_days']) : 3;
            $data ['manage_cost_money'] = isset($_POST ['manage_cost_money']) ? floatval($_POST ['manage_cost_money']) * 100 : 20000;

            $res = \Model\Admin\Params::save('p2p', $data);
            $msg = $res ? '设置成功' : '设置失败';
            $this->fontRedirect($msg, '/index.php?app=admin&mod=system&ac=params');
        }
    }

    //免费配资参数数据更新
    public function doPeiziFree() {
        if ($_POST) {
            $data ['status'] = isset($_POST ['status']) ? $_POST ['status'] : 0;
            $data ['baozheng_free'] = isset($_POST ['baozheng_free']) ? floatval($_POST ['baozheng_free']) : 1;
            $data ['free_day'] = isset($_POST ['free_day']) ? intval($_POST ['free_day']) : 0;
            $data ['per_day_count'] = isset($_POST ['per_day_count']) ? intval($_POST ['per_day_count']) : 100;

            $data ['service_cost_rate'] = isset($_POST ['service_cost_rate']) ? floatval($_POST ['service_cost_rate']) : 2000;
            $data ['manage_cost_money'] = isset($_POST ['manage_cost_money']) ? floatval($_POST ['manage_cost_money']) * 100 : 0;
            $data ['alarm_rate'] = isset($_POST ['alarm_rate']) ? floatval($_POST ['alarm_rate']) : 96;
            $data ['stop_rate'] = isset($_POST ['stop_rate']) ? floatval($_POST ['stop_rate']) : 94;

            $res = \Model\Admin\Params::save('peizi_free', $data);
            $msg = $res ? '设置成功' : '设置失败';
            $this->fontRedirect($msg, '/index.php?app=admin&mod=system&ac=params');
        }
    }

    //配资数据更新
    public function doPeiziMonth() {
        if ($_POST) {
            $data ['pz_ratio1'] = isset($_POST ['pz_ratio1']) ? intval($_POST ['pz_ratio1']) : 1;
            $data ['pz_ratio2'] = isset($_POST ['pz_ratio2']) ? intval($_POST ['pz_ratio2']) : 2;
            $data ['pz_ratio3'] = isset($_POST ['pz_ratio3']) ? intval($_POST ['pz_ratio3']) : 3;
            $data ['pz_ratio4'] = isset($_POST ['pz_ratio4']) ? intval($_POST ['pz_ratio4']) : 4;
            $data ['pz_ratio5'] = isset($_POST ['pz_ratio5']) ? intval($_POST ['pz_ratio5']) : 5;
            $data ['pz_ratio6'] = isset($_POST ['pz_ratio6']) ? intval($_POST ['pz_ratio6']) : 6;
            $data ['pz_ratio7'] = isset($_POST ['pz_ratio7']) ? intval($_POST ['pz_ratio7']) : 7;
            $data ['pz_ratio8'] = isset($_POST ['pz_ratio8']) ? intval($_POST ['pz_ratio8']) : 8;
            $data ['pz_ratio9'] = isset($_POST ['pz_ratio9']) ? intval($_POST ['pz_ratio9']) : 9;
            $data ['pz_ratio10'] = isset($_POST ['pz_ratio10']) ? intval($_POST ['pz_ratio10']) : 10;

            $data ['alarm_rate1'] = isset($_POST ['alarm_rate1']) ? floatval($_POST ['alarm_rate1']) : 15;
            $data ['alarm_rate2'] = isset($_POST ['alarm_rate2']) ? floatval($_POST ['alarm_rate2']) : 20;
            $data ['alarm_rate3'] = isset($_POST ['alarm_rate3']) ? floatval($_POST ['alarm_rate3']) : 25;
            $data ['alarm_rate4'] = isset($_POST ['alarm_rate4']) ? floatval($_POST ['alarm_rate4']) : 30;
            $data ['alarm_rate5'] = isset($_POST ['alarm_rate5']) ? floatval($_POST ['alarm_rate5']) : 35;
            $data ['alarm_rate6'] = isset($_POST ['alarm_rate6']) ? floatval($_POST ['alarm_rate6']) : 40;
            $data ['alarm_rate7'] = isset($_POST ['alarm_rate7']) ? floatval($_POST ['alarm_rate7']) : 45;
            $data ['alarm_rate8'] = isset($_POST ['alarm_rate8']) ? floatval($_POST ['alarm_rate8']) : 50;
            $data ['alarm_rate9'] = isset($_POST ['alarm_rate9']) ? floatval($_POST ['alarm_rate9']) : 55;
            $data ['alarm_rate10'] = isset($_POST ['alarm_rate10']) ? floatval($_POST ['alarm_rate10']) : 60;

            $data ['stop_rate1'] = isset($_POST ['stop_rate1']) ? floatval($_POST ['stop_rate1']) : 13;
            $data ['stop_rate2'] = isset($_POST ['stop_rate2']) ? floatval($_POST ['stop_rate2']) : 18;
            $data ['stop_rate3'] = isset($_POST ['stop_rate3']) ? floatval($_POST ['stop_rate3']) : 23;
            $data ['stop_rate4'] = isset($_POST ['stop_rate4']) ? floatval($_POST ['stop_rate4']) : 28;
            $data ['stop_rate5'] = isset($_POST ['stop_rate5']) ? floatval($_POST ['stop_rate5']) : 33;
            $data ['stop_rate6'] = isset($_POST ['stop_rate6']) ? floatval($_POST ['stop_rate6']) : 38;
            $data ['stop_rate7'] = isset($_POST ['stop_rate7']) ? floatval($_POST ['stop_rate7']) : 43;
            $data ['stop_rate8'] = isset($_POST ['stop_rate8']) ? floatval($_POST ['stop_rate8']) : 48;
            $data ['stop_rate9'] = isset($_POST ['stop_rate9']) ? floatval($_POST ['stop_rate9']) : 53;
            $data ['stop_rate10'] = isset($_POST ['stop_rate10']) ? floatval($_POST ['stop_rate10']) : 58;

            $data ['manage_cost_money1'] = isset($_POST ['manage_cost_money1']) ? floatval($_POST ['manage_cost_money1']) : 1;
            $data ['manage_cost_money2'] = isset($_POST ['manage_cost_money2']) ? floatval($_POST ['manage_cost_money2']) : 1;
            $data ['manage_cost_money3'] = isset($_POST ['manage_cost_money3']) ? floatval($_POST ['manage_cost_money3']) : 1;
            $data ['manage_cost_money4'] = isset($_POST ['manage_cost_money4']) ? floatval($_POST ['manage_cost_money4']) : 1;
            $data ['manage_cost_money5'] = isset($_POST ['manage_cost_money5']) ? floatval($_POST ['manage_cost_money5']) : 1;
            $data ['manage_cost_money6'] = isset($_POST ['manage_cost_money6']) ? floatval($_POST ['manage_cost_money6']) : 1;
            $data ['manage_cost_money7'] = isset($_POST ['manage_cost_money7']) ? floatval($_POST ['manage_cost_money7']) : 1;
            $data ['manage_cost_money8'] = isset($_POST ['manage_cost_money8']) ? floatval($_POST ['manage_cost_money8']) : 1;
            $data ['manage_cost_money9'] = isset($_POST ['manage_cost_money9']) ? floatval($_POST ['manage_cost_money9']) : 1;
            $data ['manage_cost_money10'] = isset($_POST ['manage_cost_money10']) ? floatval($_POST ['manage_cost_money10']) : 1;

            $data ['minLimitMoney'] = isset($_POST ['minLimitMoney']) ? floatval($_POST ['minLimitMoney']) * 100 : 1000000;
            $data ['maxLimitMoney'] = isset($_POST ['maxLimitMoney']) ? floatval($_POST ['maxLimitMoney']) * 100 : 30000000;
            $res = \Model\Admin\Params::save('peizi_month', $data);
            $msg = $res ? '设置成功' : '设置失败';
            $this->fontRedirect($msg, '/index.php?app=admin&mod=system&ac=params');
        }
    }

    //期货数据更新
    public function doPeiziQihuo() {
        if ($_POST) {
            $data ['pz_ratio1'] = isset($_POST ['pz_ratio1']) ? intval($_POST ['pz_ratio1']) : 1;
            $data ['pz_ratio2'] = isset($_POST ['pz_ratio2']) ? intval($_POST ['pz_ratio2']) : 2;
            $data ['pz_ratio3'] = isset($_POST ['pz_ratio3']) ? intval($_POST ['pz_ratio3']) : 3;
            $data ['pz_ratio4'] = isset($_POST ['pz_ratio4']) ? intval($_POST ['pz_ratio4']) : 4;
            $data ['pz_ratio5'] = isset($_POST ['pz_ratio5']) ? intval($_POST ['pz_ratio5']) : 5;
            $data ['pz_ratio6'] = isset($_POST ['pz_ratio6']) ? intval($_POST ['pz_ratio6']) : 6;
            $data ['pz_ratio7'] = isset($_POST ['pz_ratio7']) ? intval($_POST ['pz_ratio7']) : 7;
            $data ['pz_ratio8'] = isset($_POST ['pz_ratio8']) ? intval($_POST ['pz_ratio8']) : 8;
            $data ['pz_ratio9'] = isset($_POST ['pz_ratio9']) ? intval($_POST ['pz_ratio9']) : 9;
            $data ['pz_ratio10'] = isset($_POST ['pz_ratio10']) ? intval($_POST ['pz_ratio10']) : 10;

            $data ['alarm_rate1'] = isset($_POST ['alarm_rate1']) ? floatval($_POST ['alarm_rate1']) : 15;
            $data ['alarm_rate2'] = isset($_POST ['alarm_rate2']) ? floatval($_POST ['alarm_rate2']) : 20;
            $data ['alarm_rate3'] = isset($_POST ['alarm_rate3']) ? floatval($_POST ['alarm_rate3']) : 25;
            $data ['alarm_rate4'] = isset($_POST ['alarm_rate4']) ? floatval($_POST ['alarm_rate4']) : 30;
            $data ['alarm_rate5'] = isset($_POST ['alarm_rate5']) ? floatval($_POST ['alarm_rate5']) : 35;
            $data ['alarm_rate6'] = isset($_POST ['alarm_rate6']) ? floatval($_POST ['alarm_rate6']) : 40;
            $data ['alarm_rate7'] = isset($_POST ['alarm_rate7']) ? floatval($_POST ['alarm_rate7']) : 45;
            $data ['alarm_rate8'] = isset($_POST ['alarm_rate8']) ? floatval($_POST ['alarm_rate8']) : 50;
            $data ['alarm_rate9'] = isset($_POST ['alarm_rate9']) ? floatval($_POST ['alarm_rate9']) : 55;
            $data ['alarm_rate10'] = isset($_POST ['alarm_rate10']) ? floatval($_POST ['alarm_rate10']) : 60;

            $data ['stop_rate1'] = isset($_POST ['stop_rate1']) ? floatval($_POST ['stop_rate1']) : 13;
            $data ['stop_rate2'] = isset($_POST ['stop_rate2']) ? floatval($_POST ['stop_rate2']) : 18;
            $data ['stop_rate3'] = isset($_POST ['stop_rate3']) ? floatval($_POST ['stop_rate3']) : 23;
            $data ['stop_rate4'] = isset($_POST ['stop_rate4']) ? floatval($_POST ['stop_rate4']) : 28;
            $data ['stop_rate5'] = isset($_POST ['stop_rate5']) ? floatval($_POST ['stop_rate5']) : 33;
            $data ['stop_rate6'] = isset($_POST ['stop_rate6']) ? floatval($_POST ['stop_rate6']) : 38;
            $data ['stop_rate7'] = isset($_POST ['stop_rate7']) ? floatval($_POST ['stop_rate7']) : 43;
            $data ['stop_rate8'] = isset($_POST ['stop_rate8']) ? floatval($_POST ['stop_rate8']) : 48;
            $data ['stop_rate9'] = isset($_POST ['stop_rate9']) ? floatval($_POST ['stop_rate9']) : 53;
            $data ['stop_rate10'] = isset($_POST ['stop_rate10']) ? floatval($_POST ['stop_rate10']) : 58;

            $data ['manage_cost_money1'] = isset($_POST ['manage_cost_money1']) ? floatval($_POST ['manage_cost_money1']) : 1;
            $data ['manage_cost_money2'] = isset($_POST ['manage_cost_money2']) ? floatval($_POST ['manage_cost_money2']) : 1;
            $data ['manage_cost_money3'] = isset($_POST ['manage_cost_money3']) ? floatval($_POST ['manage_cost_money3']) : 1;
            $data ['manage_cost_money4'] = isset($_POST ['manage_cost_money4']) ? floatval($_POST ['manage_cost_money4']) : 1;
            $data ['manage_cost_money5'] = isset($_POST ['manage_cost_money5']) ? floatval($_POST ['manage_cost_money5']) : 1;
            $data ['manage_cost_money6'] = isset($_POST ['manage_cost_money6']) ? floatval($_POST ['manage_cost_money6']) : 1;
            $data ['manage_cost_money7'] = isset($_POST ['manage_cost_money7']) ? floatval($_POST ['manage_cost_money7']) : 1;
            $data ['manage_cost_money8'] = isset($_POST ['manage_cost_money8']) ? floatval($_POST ['manage_cost_money8']) : 1;
            $data ['manage_cost_money9'] = isset($_POST ['manage_cost_money9']) ? floatval($_POST ['manage_cost_money9']) : 1;
            $data ['manage_cost_money10'] = isset($_POST ['manage_cost_money10']) ? floatval($_POST ['manage_cost_money10']) : 1;

            $res = \Model\Admin\Params::save('peizi_qihuo', $data);
            $msg = $res ? '设置成功' : '设置失败';
            $this->fontRedirect($msg, '/index.php?app=admin&mod=system&ac=params');
        }
    }

    //网站基本信息数据更新
    public function doSiteBase() {
        if ($_POST) {
            $data ['site_name'] = isset($_POST ['site_name']) ? \App::t($_POST ['site_name']) : '';
            $data ['site_logo'] = isset($_POST ['site_logo']) ? \App::t($_POST ['site_logo']) : '';
            $data ['site_weixin'] = isset($_POST ['site_weixin']) ? \App::t($_POST ['site_weixin']) : '';
            $data ['site_url'] = isset($_POST ['site_url']) ? \App::t($_POST ['site_url']) : '';
            $data ['site_service_url'] = isset($_POST ['site_service_url']) ? \App::t($_POST ['site_service_url']) : '';
            $data ['site_service_script'] = isset($_POST ['site_service_script']) ? $_POST ['site_service_script'] : '';
            $data ['site_phone'] = isset($_POST ['site_phone']) ? \App::t($_POST ['site_phone']) : '';
            $data ['site_title'] = isset($_POST ['site_title']) ? \App::t($_POST ['site_title']) : '';
            $data ['site_keywords'] = isset($_POST ['site_keywords']) ? \App::t($_POST ['site_keywords']) : '';
            $data ['site_description'] = isset($_POST ['site_description']) ? \App::t($_POST ['site_description']) : '';
            $data ['site_qq'] = isset($_POST ['site_qq']) ? \App::t($_POST ['site_qq']) : '';
            $data ['site_copyright'] = isset($_POST ['site_copyright']) ? $_POST ['site_copyright'] : '';
            //$data ['recharge_send_per'] = isset ( $_POST ['recharge_send_per'] ) ? floatval($_POST ['recharge_send_per']) : 0;
            //$data ['recharge_send_max'] = isset ( $_POST ['recharge_send_max'] ) ? floatval($_POST ['recharge_send_max']) : 0;
            $data ['jsryj_per'] = isset($_POST ['jsryj_per']) ? floatval($_POST ['jsryj_per']) : 0;
            $res = \Model\Admin\Params::save('site_base', $data);
            $msg = $res ? '设置成功' : '设置失败';
            $this->fontRedirect($msg, '/index.php?app=admin&mod=system&ac=view');
        }
    }

    //支付接口设置
    public function doPay() {
        if ($_POST) {
            $data ['pay_bus'] = isset($_POST ['pay_bus']) ? \App::t($_POST ['pay_bus']) : 'yeepay';
            $data ['pay_bus_wx'] = isset($_POST ['pay_bus_wx']) ? \App::t($_POST ['pay_bus_wx']) : 'swiftpass';
            $data ['pay_bus_zfb'] = isset($_POST ['pay_bus_zfb']) ? \App::t($_POST ['pay_bus_zfb']) : 'swiftpass';
            $data ['pay_name'] = isset($_POST ['pay_name']) ? \App::t($_POST ['pay_name']) : '';
            $data ['pay_start'] = isset($_POST ['pay_start']) ? intval($_POST ['pay_start']) : 1;
            $data ['pay_key'] = isset($_POST ['pay_key']) ? \App::t($_POST ['pay_key']) : '';
            $data ['pay_id'] = isset($_POST ['pay_id']) ? \App::t($_POST ['pay_id']) : '';
            $res = \Model\Admin\Params::save('site_pay', $data);
            $msg = $res ? '设置成功' : '设置失败';
            $this->fontRedirect($msg, '/index.php?app=admin&mod=system&ac=view&type=2');
        }
    }

    //短信接口设置
    public function doSms() {
        if ($_POST) {
            $data ['mid'] = isset($_POST ['mid']) ? \App::t($_POST ['mid']) : '';
            $data ['mpass'] = isset($_POST ['mpass']) ? $_POST ['mpass'] : '';
            $data ['mqianming'] = isset($_POST ['mqianming']) ? \App::t($_POST ['mqianming']) : '【' . SITE_NAME . '】';
            $res = \Model\Admin\Params::save('site_sms', $data);
            $msg = $res ? '设置成功' : '设置失败';
            $this->fontRedirect($msg, '/index.php?app=admin&mod=system&ac=view&type=3');
        }
    }

    //SQL命令行工具
    public function query() {
        $this->setTitle('SQL命令行工具');
        $tables = \Common\Query::sqlsel('show tables;');

        $msg = '';
        if ($_POST) {
            $sqlquery = isset($_POST ['sqlquery']) ? $_POST ['sqlquery'] : '';
            $querytype = isset($_POST ['querytype']) ? intval($_POST ['querytype']) : 0;
            $table_name = isset($_POST ['table_name']) ? $_POST ['table_name'] : '';

            $sqlquery = trim(stripslashes($sqlquery));
            if (preg_match("#drop(.*)table#i", $sqlquery) || preg_match("#drop(.*)database#", $sqlquery)) {
                $msg .= "<span style='font-size:10pt'>删除'数据表'或'数据库'的语句不允许在这里执行。</span>";
            }

            //运行查询语句
            $sqlquery = trim(stripslashes($sqlquery));
            if (preg_match("#drop(.*)table#i", $sqlquery) || preg_match("#drop(.*)database#", $sqlquery)) {
                $msg .= "<span style='font-size:10pt'>删除'数据表'或'数据库'的语句不允许在这里执行。</span>";
            }

            if ($sqlquery == '') {
                $sqlquery = $table_name;
            }

            //运行查询语句
            if ($table_name) {
                $data = \Common\Query::select($sqlquery);
                $totalRow = count($data);

                if ($totalRow <= 0) {
                    $msg .= "运行SQL：{$sqlquery}，无返回记录！";
                } else {
                    $msg .= "运行SQL：{$sqlquery}，共有" . $totalRow . "条记录，最大返回100条！";
                }
                $j = 0;

                foreach ($data as $row) {
                    $j ++;
                    if ($j > 100) {
                        break;
                    }
                    $msg .= "<hr size=1 width='100%'/>";
                    $msg .= "记录：$j";
                    $msg .= "<hr size=1 width='100%'/>";
                    $index = 1;
                    foreach ($row as $k => $v) {
                        $msg .= "<font color='red'>[{$k}]：</font>{$v}&nbsp;&nbsp;\r\n";
                        if ($index % 5 == 0) {
                            $msg .= '<br/>';
                        }
                        $index ++;
                    }
                }
            }

            if ($querytype == 2 && !$table_name) {
                //普通的SQL语句
                $sqlquery = str_replace("\r", "", $sqlquery);
                $sqls = preg_split("#;[ \t]{0,}\n#", $sqlquery);
                $nerrCode = "";
                $i = 0;
                foreach ($sqls as $q) {
                    $q = trim($q);
                    if ($q == "") {
                        continue;
                    }
                    \Common\Query::sqlquery($q);
                    $errCode = trim(\Common\Query::getError());
                    if ($errCode == "") {
                        $i ++;
                    } else {
                        $nerrCode .= "执行： <font color='blue'>$q</font> 出错，错误提示：<font color='red'>" . $errCode . "</font><br>";
                    }
                }
                $msg .= "成功执行{$i}个SQL语句！";
                $msg .= $nerrCode;
            } elseif ($querytype == 0 && !$table_name) {
                $data = \Common\Query::select($sqlquery);

                $totalRow = count($data);
                if ($totalRow <= 0) {
                    $msg .= "运行SQL：{$sqlquery}，无返回记录！";
                } else {
                    $msg .= "运行SQL：{$sqlquery}，共有" . $totalRow . "条记录，最大返回100条！";
                }
                $j = 0;

                foreach ($data as $row) {
                    $j ++;
                    if ($j > 100) {
                        break;
                    }
                    $msg .= "<hr size=1 width='100%'/>";
                    $msg .= "记录：$j";
                    $msg .= "<hr size=1 width='100%'/>";
                    $index = 1;
                    foreach ($row as $k => $v) {
                        $msg .= "<font color='red'>[{$k}]：</font>{$v}&nbsp;&nbsp;\r\n";
                        if ($index % 5 == 0) {
                            $msg .= '<br/>';
                        }
                        $index ++;
                    }
                }

                $nerrCode = trim(\Common\Query::getError());
                if ($data) {
                    $msg .= "<br/>成功执行" . $totalRow . "个SQL语句！";
                }
                $msg .= $nerrCode;
            }
        }

        $this->assign('tables', $tables);
        $this->assign('msg', $msg);
        $this->template('query.php');
    }

    public function getprofit() {
        $this->setTitle('盈利提取');
        $condition['pz_id'] = isset ( $_GET ['pz_id'] ) ? intval($_GET ['pz_id']) :0;
        $condition['uid'] = isset ( $_GET ['uid'] ) ? intval($_GET ['uid']) :0;
        $condition['mobile'] = isset ( $_GET ['mobile'] ) ? $_GET ['mobile'] :0;
        $condition['status'] = isset ( $_GET ['status'] ) ? $_GET ['status'] :0;
        $condition['pz_type'] = isset ( $_GET ['pz_type'] ) ? intval($_GET ['pz_type']) :0;
        
        $pagesize = 20;
        $curpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $where = ' WHERE 1=1 ';
        if (!empty($condition['pz_id'])) {
            $where .= ' and record.pz_id=' . intval($condition['pz_id']);
        }
        if (!empty($condition['uid'])) {
            $where .= ' and record.uid=' . intval($condition['uid']);
        }
        if (!empty($condition['mobile'])) {
            $where .= " and info.mobile like '%" . \App::t($condition['mobile']) . "%'";
        }
        if (isset($condition['status']) && $condition['status'] != '') {
            $where .= " and record.status= " . intval($condition['status']);
        }
        if(!empty($condition['pz_type'])){
            $where .= " and pz.pz_type=".intval($condition['pz_type']);
        }
        $selarr = array('record.id', 'record.uid', 'record.money', 'record.status', 'record.add_time', 'record.update_time', 'info.true_name', 'info.mobile', 'pz.sp_user','pz.pz_type');
        $table_name = 'user_peizi_getprofit record left join user_info info on record.uid=info.uid left join user_peizi pz on record.pz_id=pz.pz_id';
        $order = ' ORDER BY record.id DESC';
        $res = \Common\Pager::getList($table_name, $where, $selarr, $order, $curpage, $pagesize);
        $this->assign ( 'condition', $condition);
        $this->assign('list', $res['data']);
        $this->assign('pager', $res['pager']);
        $this->template('getprofit.php');
    }

    public function getprofitedit() {
        $this->setTitle('盈利提取');
        $this->setNavtitle('盈利提取');
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $row = \Common\Query::selone('user_peizi_getprofit', array('id' => intval($id)));
        $user = \Model\User\UserInfo::getinfo($row['uid']);
        $this->assign('row', $row);
        $this->assign('user', $user);
        $this->template('getprofitedit.php');
    }

    public function dogetprofitedit() {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $money = isset($_POST['money']) ? floatval($_POST['money']) * 100 : 0;
        
        $url = '/index.php?app=admin&mod=system&ac=getprofit';
        if (empty($id)) {
            $this->fontRedirect('参数错误', 'back', 2);
            exit();
        }
        if (empty($money)) {
            $this->fontRedirect('金额不能为空', $url, 2);
            exit();
        }
        $udpin['money'] = $money;


        $res = \Common\Query::update('user_peizi_getprofit', $udpin, array('id' => $id,'status'=>0));
        if (!$res) {
            $this->fontRedirect('提交失败', $url, 2);
        }
        
        $this->fontRedirect('提交成功', $url, 2);
    }

    public function getprofitpass() {
        $url = '/index.php?app=admin&mod=system&ac=getprofit';
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $profit_row = \Common\Query::selone('user_peizi_getprofit', array('id' => $id));
        \Common\Query::commitstart();
        //状态修改
        $res = \Model\User\Fund::get_profit($id);
        if ($res[0] == 0) {
            \Common\Query::rollback();
            $this->fontRedirect('提交失败', $url, 2);
            exit();
        }
        //赠送管理费
        $row_count = \Common\Query::sqlselone("select count(fund_id) total from user_fund_record where uid=".$profit_row['uid']." and type=110");
        if(intval($row_count['total']) <=0){
            $params_send = \Model\Admin\Params::get('manage_send');
            $res = \Model\User\Fund::send_profit($profit_row['uid'], floatval($params_send['profit'])*100,$profit_row['pz_id']);
            if ($res[0] == 0) {
                \Common\Query::rollback();
                $this->fontRedirect('提交失败', $url, 2);
                exit();
            }
        }
        \Common\Query::commit();
        //短信通知
        $row = \Model\Peizi\GetProfit::getById($id);
        $user = \Model\User\UserInfo::getinfo($row['uid']);
        \Model\Api\Sms::smsSend($user['mobile'], \Model\Sys\SmsTemplet::peiziProfitSuccess(''));
        $this->fontRedirect('提交成功', $url, 2);
        exit();
    }

    public function getprofitrefuse() {
        $url = '/index.php?app=admin&mod=system&ac=getprofit';
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $memo = isset($_GET['memo']) ? intval($_GET['memo']) : '';
        $memo = urldecode($memo);
        $res = \Model\Peizi\GetProfit::updateRefuseStatus($id);
        if (!$res) {
            $this->fontRedirect('提交失败', $url, 2);
        }
        //短信通知
        $row = \Model\Peizi\GetProfit::getById($id);
        $user = \Model\User\UserInfo::getinfo($row['uid']);
        if(!empty($memo)){
            \Model\Api\Sms::smsSend($user['mobile'], \Model\Sys\SmsTemplet::peiziProfitRefuseMemo($memo));
        }
        else{
            \Model\Api\Sms::smsSend($user['mobile'], \Model\Sys\SmsTemplet::peiziProfitRefuse(''));
        }
        $this->fontRedirect('提交成功', $url, 2);
        exit();
    }

    public function getprofitdel() {
        $url = '/index.php?app=admin&mod=system&ac=getprofit';
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $res = \Common\Query::delete("user_peizi_getprofit", array("id" => $id));
        if (!$res) {
            $this->fontRedirect('提交失败', $url, 2);
        }
        $this->fontRedirect('提交成功', $url, 2);
        exit();
    }
    
    //参数设置
    public function send() {
        $this->setTitle('管理费赠送设置');
        $params_send = \Model\Admin\Params::get('manage_send');
        $this->assign('params_send', $params_send);
        $this->template('send.php');
    }

    //配资数据更新
    public function doSend() {
        if ($_POST) {
            $data = $_POST;
            $res = \Model\Admin\Params::save('manage_send', $data);
            $msg = $res ? '设置成功' : '设置失败';
            $this->fontRedirect($msg, '/index.php?app=admin&mod=system&ac=send');
        }
    }
    public function layer()
    {
        $this->setTitle('弹窗设置');
        $data = \Model\Admin\Params::get('layer');
        $this->assign('data', $data);
        $this->template('layer.php');
    }
    public function dolayeredit()
    {
        if ($_POST) {
            $data = $_POST;
            $res = \Model\Admin\Params::save('layer', $data);
            $msg = $res ? '设置成功' : '设置失败';
            $this->fontRedirect($msg, '/index.php?app=admin&mod=system&ac=layer');
        }
    }
	public function ewm() {
        $this->setTitle('二维码设置');
        $params_site_ewm = \Model\Admin\Params::get('ewm');
        $this->assign('params_site_ewm', $params_site_ewm);
        $this->template('ewm.php');
    }
    public function doEwmSave() {
        if ($_POST) {
            $res = \Model\Admin\Params::save('ewm', $_POST);
            $msg = $res ? '设置成功' : '设置失败';
            $this->fontRedirect($msg, '/index.php?app=admin&mod=system&ac=ewm');
        }
    }

}

?>
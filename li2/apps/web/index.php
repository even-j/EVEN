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

class index extends \core\Controller {

    //put your code here
    public function view() {
        parent::view();
        $site_base = unserialize(SITE_BASE);
        $this->setTitle($site_base['site_title']);
        $this->setKeywords($site_base['site_keywords']);
        $this->setDescription($site_base['site_description']);
        $params = \Model\Admin\Params::get('peizi');
        $params_peizi_month = \Model\Admin\Params::get('peizi_month');
        $params_peizi_free = \Model\Admin\Params::get('peizi_free');

        //首页幻灯片
//        $where = ' WHERE status=0 AND type_id=1';
//        $selarr = array('ad_name', 'ad_pic', 'ad_link');
//        $order = ' ORDER BY `order` ASC, addtime DESC';
//        $slider = \Common\Pager::getList('ad', $where, $selarr, $order, 1, 4, 0);
        //首页友情链接
//        $where = ' WHERE status=0 AND type_id=2';
//        $selarr = array('ad_name', 'ad_pic', 'ad_link');
//        $order = ' ORDER BY `order` ASC, addtime DESC';
//        $links = \Common\Pager::getList('ad', $where, $selarr, $order, 1, 4, 0);

        //网站公告
        $where = ' WHERE pid=5';
        $selarr = array('`id`','pid', '`title`', '`addtime`');
        $order = ' ORDER BY `addtime` DESC';
        $noticeList = \Common\Pager::getList('article', $where, $selarr, $order, 1, 10);
        $this->assign('noticeList', $noticeList);
        
        //媒体报道
        $where = ' WHERE pid=45';
        $selarr = array('`id`','pid', '`title`', '`addtime`');
        $order = ' ORDER BY `addtime` DESC';
        $mediaList = \Common\Pager::getList('article', $where, $selarr, $order, 1, 10);
        $this->assign('mediaList', $mediaList);
        
        //行业资讯
        $where = ' WHERE pid=44';
        $selarr = array('`id`','pid', '`title`', '`addtime`');
        $order = ' ORDER BY `addtime` DESC';
        $newsList = \Common\Pager::getList('article', $where, $selarr, $order, 1, 10);
        $this->assign('newsList', $newsList);
        
        //签到信息
        $sign = \Model\User\Sign::getByUid($this->uid);
        $this->assign('sign', $sign);
        
        //赠送管理费
        $params_send = \Model\Admin\Params::get('manage_send');
        $params_sendmoney= floatval($params_send['regist'])+floatval($params_send['sfz'])
                +floatval($params_send['bank'])+floatval($params_send['recharge'])
                +floatval($params_send['peizi'])+floatval($params_send['add'])
                +floatval($params_send['fill'])+floatval($params_send['profit']);    
        $this->assign('params_sendmoney', $params_sendmoney);
        
        //弹窗参数
        $layer_param=\Model\Admin\Params::get('layer');
        $this->assign('layer_param',$layer_param);
        
        $this->assign('uid', $this->uid);
        $this->assign('slider', $slider);
        $this->assign('links', $links);
        $this->assign('params', $params);
        $this->assign('params_peizi_month', $params_peizi_month);
        $this->assign('params_peizi_free', $params_peizi_free);
        $this->template('views.php');
    }

    public function hq_bankuai() {
        //板块行情获取
        $hangqing_data = array(); //\Common\Cache::get('hangqing_bankuai');
        if (empty($hangqing_data)) {
            $hangqing = \core\net\Curl::curlget("http://vip.stock.finance.sina.com.cn/q/view/newSinaHy.php");
            $hangqing = mb_convert_encoding($hangqing, 'utf-8', 'GBK,UTF-8,ASCII');
            $hangqing = str_replace("var S_Finance_bankuai_sinaindustry = ", "", $hangqing);
            $hangqing_arr = json_decode($hangqing, TRUE);
            $volume = array();
            foreach ($hangqing_arr as $hq) {
                $hq_arr = explode(',', $hq);
                $hangqing_data[] = array('name' => $hq_arr[1], 'zf' => round($hq_arr[5], 2));
                $volume[] = $hq_arr[5];
            }
            array_multisort($volume, SORT_ASC, $hangqing_data); //排序
            \Common\Cache::save('hangqing_bankuai', $hangqing_data, 180); //缓存3分钟
        }
        $this->assign('hangqing_data', $hangqing_data);
        $this->template('hq_bankuai.php');
    }

    public function safe() {
        $this->setTitle('安全保障' . '-' . SITE_TITLE);
        $this->template('safe.php');
    }

    public function extend() {
        $this->setTitle('推广好友' . '-' . SITE_TITLE);
        $this->template('extend.php');
    }

    public function activity() {
        $this->setTitle('新手任务' . '-' . SITE_TITLE);
        $fund_rows = array();
        if($this->uid){
            $datas = \Common\Query::sqlsel("select fund_id,type from user_fund_record where uid=".$this->uid.' and type in(103,105,106,107,108,109,110,111)');
            foreach ($datas as $data) {
                $fund_rows[$data['type']] = 1;
            }
        }
        $this->assign('fund_rows', $fund_rows);
        $params_send = \Model\Admin\Params::get('manage_send');
        $this->assign('params_send', $params_send);
        $this->template('activity.php');
    }
    
    public function renzheng() {
        $this->setTitle('');
        $this->template('renzheng.php');
    }

}

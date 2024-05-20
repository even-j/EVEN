<?php


/**
 * Description of index
 *
 * @author Administrator
 */

namespace apps\pay;

class pub extends \core\Controller {

    //put your code here
    public function qrcode() {
        require_once SITEROOT . 'Plugin/phpqrcode/phpqrcode.php';
        $text = str_replace('&amp;','&',urldecode($_GET['text']));
        \QRcode::png($text, false, QR_ECLEVEL_L, 10);
    }

    public function result_ewm() {
        $this->template('result_ewm.php');
    }
    public function is_recharge_success() {
        $recharge_id = isset($_POST ['recharge_id']) ? intval($_POST ['recharge_id']) : '';
        $row = \Common\Query::selone("user_recharge_record", array("recharge_id" => $recharge_id));
        if ($row && $row['status'] == 1) {
            echo json_encode(array('code' => 1));
        } else {
            echo json_encode(array('code' => 0));
        }
    }
   
}

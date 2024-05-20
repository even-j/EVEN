<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of App
 *
 * @author Administrator
 */
class App {

    //put your code here
    private static $appvalue;

    /**
     * 设置值
     * @param type $key
     * @param type $value
     */
    public static function set($key, $value) {
        self::$appvalue [$key] = $value;
    }

    /**
     * 获取存储的值
     * @param type $key
     * @return type
     */
    public static function get($key) {
        return isset(self::$appvalue [$key]) ? self::$appvalue [$key] : '';
    }

    /**
     * 加载插件
     * @param type $path
     * @param type $files
     */
    public static function loadPlugin($path, $files) {
        require_once PLUGIN . $path . DIRECTORY_SEPARATOR . $files;
    }

    public static function autoload($classname) {
        $class_path = str_replace('\\', DIRECTORY_SEPARATOR, $classname);
        $class_file = SITEROOT . $class_path . '.php';
        if (is_file($class_file)) {
            require_once ($class_file);
            if (class_exists($classname, false)) {
                return true;
            }
        }
        return false;
    }

    /**
     * 获得在线ip
     * @param type $format
     * @return type
     */
    public static function getonlineip($format = 0) {
        if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $onlineip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $onlineip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $onlineip = getenv('REMOTE_ADDR');
        } elseif (isset($_SERVER ['REMOTE_ADDR']) && $_SERVER ['REMOTE_ADDR'] && strcasecmp($_SERVER ['REMOTE_ADDR'], 'unknown')) {
            $onlineip = $_SERVER ['REMOTE_ADDR'];
        }
        preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
        if ($onlineipmatches) {
            $onlineip = $onlineipmatches [0] ? $onlineipmatches [0] : 'unknown';
        }
        self::set('onlineip', $onlineip);
        if ($format) {
            return ip2long($onlineip);
        }
        return $onlineip;
    }

    /**
     * 获取给定IP的物理地址
     *
     * @param string $ip
     * @return string
     */
    public static function convert_ip($ip) {
        $return = '';
        if (preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/", $ip)) {
            $iparray = explode('.', $ip);
            if ($iparray [0] == 10 || $iparray [0] == 127 || ($iparray [0] == 192 && $iparray [1] == 168) || ($iparray [0] == 172 && ($iparray [1] >= 16 && $iparray [1] <= 31))) {
                $return = '- LAN';
            } elseif ($iparray [0] > 255 || $iparray [1] > 255 || $iparray [2] > 255 || $iparray [3] > 255) {
                $return = '- Invalid IP Address';
            } else {
                $tinyipfile = SITEROOT . '/data/tinyipdata.dat';
                $fullipfile = SITEROOT . '/data/wry.dat';
                if (@file_exists($tinyipfile)) {
                    $return = self::convert_ip_tiny($ip, $tinyipfile);
                } elseif (@file_exists($fullipfile)) {
                    $return = self::convert_ip_full($ip, $fullipfile);
                }
            }
        }

        $return = iconv('GBK', 'UTF-8', $return);
        return $return;
    }

    private static function convert_ip_tiny($ip, $ipdatafile) {
        static $fp = NULL, $offset = array(), $index = NULL;
        $ipdot = explode('.', $ip);
        $ip = pack('N', ip2long($ip));
        $ipdot [0] = (int) $ipdot [0];
        $ipdot [1] = (int) $ipdot [1];

        if ($fp === NULL && $fp = @fopen($ipdatafile, 'rb')) {
            $offset = @unpack('Nlen', @fread($fp, 4));
            $index = @fread($fp, $offset ['len'] - 4);
        } elseif ($fp == FALSE) {
            return '- Invalid IP data file';
        }

        $length = $offset ['len'] - 1028;
        $start = @unpack('Vlen', $index [$ipdot [0] * 4] . $index [$ipdot [0] * 4 + 1] . $index [$ipdot [0] * 4 + 2] . $index [$ipdot [0] * 4 + 3]);

        for ($start = $start ['len'] * 8 + 1024; $start < $length; $start += 8) {
            if ($index {$start} . $index {$start + 1} . $index {$start + 2} . $index {$start + 3} >= $ip) {
                $index_offset = @unpack('Vlen', $index {$start + 4} . $index {$start + 5} . $index {$start + 6} . "\x0");
                $index_length = @unpack('Clen', $index {$start + 7});
                break;
            }
        }
        @fseek($fp, $offset ['len'] + $index_offset ['len'] - 1024);
        if ($index_length ['len']) {
            return '- ' . @fread($fp, $index_length ['len']);
        } else {
            return '- Unknown';
        }
    }

    private static function convert_ip_full($ip, $ipdatafile) {
        if (!$fd = @fopen($ipdatafile, 'rb')) {
            return '- Invalid IP data file';
        }
        $ip = explode('.', $ip);
        $ipNum = $ip [0] * 16777216 + $ip [1] * 65536 + $ip [2] * 256 + $ip [3];
        if (!($DataBegin = fread($fd, 4)) || !($DataEnd = fread($fd, 4)))
            return;
        @$ipbegin = implode('', unpack('L', $DataBegin));
        if ($ipbegin < 0)
            $ipbegin += pow(2, 32);
        @$ipend = implode('', unpack('L', $DataEnd));
        if ($ipend < 0)
            $ipend += pow(2, 32);
        $ipAllNum = ($ipend - $ipbegin) / 7 + 1;

        $BeginNum = $ip2num = $ip1num = 0;
        $ipAddr1 = $ipAddr2 = '';
        $EndNum = $ipAllNum;

        while ($ip1num > $ipNum || $ip2num < $ipNum) {
            $Middle = intval(($EndNum + $BeginNum) / 2);
            fseek($fd, $ipbegin + 7 * $Middle);
            $ipData1 = fread($fd, 4);
            if (strlen($ipData1) < 4) {
                fclose($fd);
                return '- System Error';
            }
            $ip1num = implode('', unpack('L', $ipData1));
            if ($ip1num < 0)
                $ip1num += pow(2, 32);

            if ($ip1num > $ipNum) {
                $EndNum = $Middle;
                continue;
            }

            $DataSeek = fread($fd, 3);
            if (strlen($DataSeek) < 3) {
                fclose($fd);
                return '- System Error';
            }
            $DataSeek = implode('', unpack('L', $DataSeek . chr(0)));
            fseek($fd, $DataSeek);
            $ipData2 = fread($fd, 4);
            if (strlen($ipData2) < 4) {
                fclose($fd);
                return '- System Error';
            }
            $ip2num = implode('', unpack('L', $ipData2));
            if ($ip2num < 0)
                $ip2num += pow(2, 32);

            if ($ip2num < $ipNum) {
                if ($Middle == $BeginNum) {
                    fclose($fd);
                    return '- Unknown';
                }
                $BeginNum = $Middle;
            }
        }

        $ipFlag = fread($fd, 1);
        if ($ipFlag == chr(1)) {
            $ipSeek = fread($fd, 3);
            if (strlen($ipSeek) < 3) {
                fclose($fd);
                return '- System Error';
            }
            $ipSeek = implode('', unpack('L', $ipSeek . chr(0)));
            fseek($fd, $ipSeek);
            $ipFlag = fread($fd, 1);
        }

        if ($ipFlag == chr(2)) {
            $AddrSeek = fread($fd, 3);
            if (strlen($AddrSeek) < 3) {
                fclose($fd);
                return '- System Error';
            }
            $ipFlag = fread($fd, 1);
            if ($ipFlag == chr(2)) {
                $AddrSeek2 = fread($fd, 3);
                if (strlen($AddrSeek2) < 3) {
                    fclose($fd);
                    return '- System Error';
                }
                $AddrSeek2 = implode('', unpack('L', $AddrSeek2 . chr(0)));
                fseek($fd, $AddrSeek2);
            } else {
                fseek($fd, - 1, SEEK_CUR);
            }

            while (($char = fread($fd, 1)) != chr(0))
                $ipAddr2 .= $char;

            $AddrSeek = implode('', unpack('L', $AddrSeek . chr(0)));
            fseek($fd, $AddrSeek);

            while (($char = fread($fd, 1)) != chr(0))
                $ipAddr1 .= $char;
        } else {
            fseek($fd, - 1, SEEK_CUR);
            while (($char = fread($fd, 1)) != chr(0))
                $ipAddr1 .= $char;

            $ipFlag = fread($fd, 1);
            if ($ipFlag == chr(2)) {
                $AddrSeek2 = fread($fd, 3);
                if (strlen($AddrSeek2) < 3) {
                    fclose($fd);
                    return '- System Error';
                }
                $AddrSeek2 = implode('', unpack('L', $AddrSeek2 . chr(0)));
                fseek($fd, $AddrSeek2);
            } else {
                fseek($fd, - 1, SEEK_CUR);
            }
            while (($char = fread($fd, 1)) != chr(0))
                $ipAddr2 .= $char;
        }
        fclose($fd);

        if (preg_match('/http/i', $ipAddr2)) {
            $ipAddr2 = '';
        }
        $ipaddr = "$ipAddr1 $ipAddr2";
        $ipaddr = preg_replace('/CZ88\.NET/is', '', $ipaddr);
        $ipaddr = preg_replace('/^\s*/is', '', $ipaddr);
        $ipaddr = preg_replace('/\s*$/is', '', $ipaddr);
        if (preg_match('/http/i', $ipaddr) || $ipaddr == '') {
            $ipaddr = '- Unknown';
        }
        return '- ' . $ipaddr;
    }

    /**
     * 检查是否是以手机浏览器进入(IN_MOBILE)
     * 不判断手机浏览器，直接用手机域名
     */
    public static function isMobile() {
        $mobile = array();
        static $mobilebrowser_list = 'Mobile|iPhone|Android|WAP|NetFront|JAVA|OperasMini|UCWEB|WindowssCE|Symbian|Series|webOS|SonyEricsson|Sony|BlackBerry|Cellphone|dopod|Nokia|samsung|PalmSource|Xphone|Xda|Smartphone|PIEPlus|MEIZU|MIDP|CLDC';
        //note 获取手机浏览器
        if (preg_match("/$mobilebrowser_list/i", $_SERVER ['HTTP_USER_AGENT'], $mobile)) {
            return true;
        } else {
            if (preg_match('/(mozilla|chrome|safari|opera|m3gate|winwap|openwave)/i', $_SERVER ['HTTP_USER_AGENT'])) {
                return false;
            } else {
                if ($_GET ['mobile'] === 'yes') {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    /**
     * 判断是否微信打开
     * @return boolean
     */
    public static function isWeixin() {
        if (strpos($_SERVER ['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return true;
        }
        return false;
    }

    //获取客户端设备是否为IOS
    public static function isIOS() {
        $agent = strtolower($_SERVER ['HTTP_USER_AGENT']);
        if (strpos($agent, 'iphone') || strpos($agent, 'ipad')) {
            return true;
        }
        return false;
    }

    //获取客户端设备是否为android
    public static function isAndroid() {
        $agent = strtolower($_SERVER ['HTTP_USER_AGENT']);
        if (strpos($agent, 'android')) {
            return true;
        }
        return false;
    }

    /**
     * 获取二维数组的某个键值新数组
     * @param type $arr
     * @param type $key
     * @return type
     */
    public static function getSubValue($arr, $key) {
        if (!is_array($arr) || empty($arr)) {
            return array();
        }
        $newarr = array();
        foreach ($arr as $v) {
            if (isset($v [$key])) {
                $newarr [] = $v [$key];
            }
        }
        return $newarr;
    }

    /**
     * 输出日志
     * @param type $cons
     */
    public static function logs($filename, $content) {
        $logsarr = \apps\Config::getInstance()->logspath;
        $content = (array) $content;
        $content = var_export($content, 1);
        $key = App::get('currentapp');
        $content = date('Y-m-d H:i:s', time()) . "\t" . $content . "\r\n";
        $path = $logsarr ['path'] . DIRECTORY_SEPARATOR . $key . '-' . $filename;

        file_put_contents($path, $content, FILE_APPEND);
    }

    /**
     * t函数用于过滤标签，输出没有html的干净的文本
     * @param string text 文本内容
     * @return string 处理后内容
     */
    public static function t($text) {
        $text = nl2br($text);
        $text = self::real_strip_tags($text);
        $text = addslashes($text);
        $text = trim($text);
        $text = rawurldecode($text);
        $text = str_replace('../', '', $text);//
        $text = str_replace('\'', '&prime;', $text);
        return $text;
    }

    public static function rand_str($len, $type = 1) {
        $chars = '0123456789';
        if ($type == 0) {
            $chars = '0123456789qwertyuiopasdfghjklzxcvbnm';
        }
        $string = '';
        for (; $len >= 1; $len--) {
            $position = rand() % strlen($chars);
            $string .= substr($chars, $position, 1);
        }
        return $string;
    }

    public static function real_strip_tags($str, $allowable_tags = "") {
        $str = html_entity_decode($str, ENT_QUOTES, 'UTF-8');
        return strip_tags($str, $allowable_tags);
    }

    /**
     * 统计中文字符串长度的函数
     * @param type $str
     * @return int
     */
    public static function abslength($str) {
        if (empty($str)) {
            return 0;
        }
        if (function_exists('mb_strlen')) {
            return mb_strlen($str, 'utf-8');
        } else {
            preg_match_all("/./u", $str, $ar);
            return count($ar [0]);
        }
    }

    /**
      +----------------------------------------------------------
     * 字符串截取，支持中文和其它编码
      +----------------------------------------------------------
     * @static
     * @access public
      +----------------------------------------------------------
     * @param string $str 需要转换的字符串
     * @param string $start 开始位置
     * @param string $length 截取长度
     * @param string $charset 编码格式
     * @param string $suffix 截断显示字符
      +----------------------------------------------------------
     * @return string
      +----------------------------------------------------------
     */
    public static function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true) {
        if (function_exists("mb_substr"))
            $slice = mb_substr($str, $start, $length, $charset);
        elseif (function_exists('iconv_substr')) {
            $slice = iconv_substr($str, $start, $length, $charset);
        } else {
            $re ['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
            $re ['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
            $re ['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
            $re ['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
            preg_match_all($re [$charset], $str, $match);
            $slice = join("", array_slice($match [0], $start, $length));
        }
        if ($suffix && $str != $slice)
            return $slice;
        return $slice;
    }

    /**
     * 获得性别
     * @param type $id_card
     * @return string
     */
    public static function getSexy($id_card) {
        if (empty($id_card)) {
            return '**';
        }
        return substr($id_card, (strlen($id_card) == 15 ? -1 : -2), 1) % 2 ? '先生' : '女士';
    }

    /**
     * 计算两个日期的间隔天数 $date1－$date2
     * @param type $date1
     * @param type $date2
     * @return type
     */
    public static function daysSpan($date1, $date2) {
        $date1 = date('Y-m-d', $date1);
        $date2 = date('Y-m-d', $date2);
        $date_list_a1 = explode("-", $date1);
        $date_list_a2 = explode("-", $date2);
        $d1 = mktime(0, 0, 0, $date_list_a1 [1], $date_list_a1 [2], $date_list_a1 [0]);
        $d2 = mktime(0, 0, 0, $date_list_a2 [1], $date_list_a2 [2], $date_list_a2 [0]);
        $days = round(($d1 - $d2) / 3600 / 24);
        return $days;
    }

    /**
     * 生成唯一字符串
     * @return type
     */
    public static function guid() {
        $id = str_replace('.', '', uniqid('', true));
        //$id = rand(1000, 9999).substr($id, 3);
        return $id;
    }

    /**
     * 获取某个时间段的工作日天数 
     * @param string $start_date
     * @param string $end_date
     * @return int
     */
    public static function get_work_days($start_date, $end_date, $is_workday = true) {
        if (strtotime($start_date) > strtotime($end_date)) {
            list ( $start_date, $end_date ) = array($end_date, $start_date);
        }
        $start_reduce = $end_add = 0;
        $start_N = date('N', strtotime($start_date));
        $start_reduce = ($start_N == 7) ? 1 : 0;
        $end_N = date('N', strtotime($end_date));
        in_array($end_N, array(6, 7)) && $end_add = ($end_N == 7) ? 2 : 1;
        $alldays = abs(strtotime($end_date) - strtotime($start_date)) / 86400 + 1;
        $weekend_days = floor(($alldays + $start_N - 1 - $end_N) / 7) * 2 - $start_reduce + $end_add;
        if ($is_workday) {
            $workday_days = $alldays - $weekend_days;
            return $workday_days;
        }
        return $weekend_days;
    }

    /**
     * 日期转换
     * @return string
     */
    function format_date($dateLine) {
        /* $t = time () - $dateLine;
          $f = array ('31536000' => '年', '2592000' => '个月', '604800' => '星期', '86400' => '天', '3600' => '小时', '60' => '分钟', '1' => '秒' );
          foreach ( $f as $k => $v ) {
          if (0 != $c = floor ( $t / ( int ) $k )) {
          return $c . $v . '前';
          }
          } */
        $nowtimed = time() - $dateLine;
        if ($nowtimed < 60)
            return $nowtimed . '秒前';
        if ($nowtimed < 360)
            return intval($nowtimed / 60) . '分钟前';
        if ($nowtimed < 86400)
            return intval($nowtimed / 360) . '小时前';
        if ($nowtimed < 172800)
            return '昨天';
        if ($nowtimed < 259200)
            return '前天';
        return date('Y-m-d', $dateLine);
    }

    /**
     * 加载app的配置文件
     * @return string
     */
    public static function loadAppConfig($filename) {
        $path = App::get('currentapppath') . 'conf' . DIRECTORY_SEPARATOR . $filename . '.php';
        if (is_file($path)) {
            echo $path;
            return require $path;
        }
        return array(0, $path . '==not exit');
    }

    /**
     * URL函数用于生成URL地址
     * @param string $url 特有URL标识符
     * @param array $params URL附加参数
     * @param bool $redirect 是否自动跳转到生成的URL
     * @return string 输出URL
     */
    public static function URL($url, $params = false, $redirect = false) {
        //普通模式
        if (false == strpos($url, '/')) {
            $url .= '//';
        }

        //填充默认参数
        $urls = explode('/', $url);
        $app = isset($urls [0]) && !empty($urls [0]) ? $urls [0] : 'web';
        $mod = isset($urls [1]) && !empty($urls [1]) ? $urls [1] : 'index';
        $act = isset($urls [2]) && !empty($urls [2]) ? $urls [2] : 'view';

        $site_url = '/index.php?app=' . $app . '&mod=' . $mod . '&ac=' . $act;
        //填充附加参数
        if ($params) {
            if (is_array($params)) {
                $params = http_build_query($params);
                $params = urldecode($params);
            }
            $params = str_replace('&amp;', '&', $params);
            $site_url .= '&' . $params;
        }

        //开启路由和Rewrite
        if (\apps\Config::getInstance()->rewrite) {
            //载入路由
            $router_ruler = \apps\Config::getInstance()->router;
            $router_key = $app . '/' . $mod . '/' . $act;

            //路由命中
            if (isset($router_ruler [$router_key])) {

                //填充路由参数
                if (false == strpos($router_ruler [$router_key], '://')) {
                    $site_url = DOMAIN . $router_ruler [$router_key];
                } else {
                    $site_url = DOMAIN . $router_ruler [$router_key];
                }

                //填充附加参数
                if ($params) {
                    //解析替换URL中的参数
                    parse_str($params, $r);
                    foreach ($r as $k => $v) {
                        if (strpos($site_url, '[' . $k . ']')) {
                            $site_url = str_replace('[' . $k . ']', $v, $site_url);
                        } else {
                            $lr [$k] = $v;
                        }
                    }

                    //填充剩余参数
                    if (isset($lr) && is_array($lr) && count($lr) > 0) {
                        $site_url .= '?' . http_build_query($lr);
                    }
                }
            }
        }

        //输出地址或跳转
        if ($redirect) {
            ob_clean();
            header("location:" . $site_url);
            exit();
        } else {
            return $site_url;
        }
    }

    public static function getURL($url, $params = FALSE) {
        if (strpos($url, '?') !== FALSE) {
            $url_arr = explode('&amp;', $url);
            if (is_array($url_arr)) {
                foreach ($url_arr as $key => $val) {
                    $temp_arr = explode('=', $val);
                    if ($key == 0) {
                        $app = $temp_arr[1];
                    }
                    if ($key == 1) {
                        $mod = $temp_arr[1];
                    }
                    if ($key == 2) {
                        $act = $temp_arr[1];
                    }
                    if ($key == 3) {
                        $params = array($temp_arr[0] => $temp_arr[1]);
                    }
                }

                $app = isset($app) && !empty($app) ? $app : 'web';
                $mod = isset($mod) && !empty($mod) ? $mod : 'index';
                $act = isset($act) && !empty($act) ? $act : 'view';
                return self::URL($app . '/' . $mod . '/' . $act, $params);
            }
        }
        return $url;
    }

    //人民币转大写
    /**
     * 数字金额转换成中文大写金额的函数
     * String Int  $num  要转换的小写数字或小写字符串
     * return 大写字母
     * 小数位为两位
     * */
    function num_to_rmb($num) {
        $c1 = "零壹贰叁肆伍陆柒捌玖";
        $c2 = "分角元拾佰仟万拾佰仟亿";
        //精确到分后面就不要了，所以只留两个小数位
        $num = round($num, 2);
        //将数字转化为整数
        $num = $num * 100;
        if (strlen($num) > 10) {
            return "金额太大，请检查";
        }
        $i = 0;
        $c = "";
        while (1) {
            if ($i == 0) {
                //获取最后一位数字
                $n = substr($num, strlen($num) - 1, 1);
            } else {
                $n = $num % 10;
            }
            //每次将最后一位数字转化为中文
            $p1 = substr($c1, 3 * $n, 3);
            $p2 = substr($c2, 3 * $i, 3);
            if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '万' || $p2 == '元'))) {
                $c = $p1 . $p2 . $c;
            } else {
                $c = $p1 . $c;
            }
            $i = $i + 1;
            //去掉数字最后一位了
            $num = $num / 10;
            $num = (int) $num;
            //结束循环
            if ($num == 0) {
                break;
            }
        }
        $j = 0;
        $slen = strlen($c);
        while ($j < $slen) {
            //utf8一个汉字相当3个字符
            $m = substr($c, $j, 6);
            //处理数字中很多0的情况,每次循环去掉一个汉字“零”
            if ($m == '零元' || $m == '零万' || $m == '零亿' || $m == '零零') {
                $left = substr($c, 0, $j);
                $right = substr($c, $j + 3);
                $c = $left . $right;
                $j = $j - 3;
                $slen = $slen - 3;
            }
            $j = $j + 3;
        }
        //这个是为了去掉类似23.0中最后一个“零”字
        if (substr($c, strlen($c) - 3, 3) == '零') {
            $c = substr($c, 0, strlen($c) - 3);
        }
        //将处理的汉字加上“整”
        if (empty($c)) {
            return "零元整";
        } else {
            return $c . "整";
        }
    }

    //删除所有空格
    public static function trim_all($str) {
        if (is_array($str)) {
            return array_map(array('App', 'trim_all'), $str);
        }
        $qian = array(" ", "　", "\t", "\n", "\r");
        $hou = array("", "", "", "", "");
        return str_replace($qian, $hou, $str);
    }

    /**
     * 求两个日期之间相差的天数 $day1-$day2
     * (针对1970年1月1日之后，求之前可以采用泰勒公式)
     * @param string $day1 格式：Y-m-d
     * @param string $day2 格式：Y-m-d
     * @return number
     */
    public static function diffBetweenTwoDays($day1, $day2) {
        $second1 = strtotime($day1);
        $second2 = strtotime($day2);

        if ($second1 < $second2) {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
        }
        return ($second1 - $second2) / 86400;
    }
}

if (function_exists('spl_autoload_register')) {
    spl_autoload_register(array('App', 'autoload'));
}
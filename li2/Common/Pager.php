<?php

namespace Common;

class Pager {

    /**
     *  获取动态的分页列表
     * @access    public
     * @param     string  $cur_page  当前页
     * @param     string  $total_result  总记录数
     * @param     string  $page_size  分页数量
     * @return    string
     */
    public static function getPageList($cur_page, $total_result, $page_size, $listitem = "home,pre,option,num,next,last,total") {
        $plist = $prepage = $nextpage = $homepage = $lastpage = $numpage = '';
        $prepagenum = $cur_page - 1;
        $nextpagenum = $cur_page + 1;

        $totalpage = ceil($total_result / $page_size);

        $purl = Pager::getCurUrl();
        $purl = preg_replace('/&page=(\d+)/i', '', $purl);
        $optionlist = '';
        if (\apps\Config::getInstance()->rewrite) {
            $purl = strpos($purl, '?') > 0 ? $purl : str_replace('&', '?&', $purl);
        }
        if ($cur_page != 1) {
            $homepage .= "<li><a href='" . $purl . "' title='首页'>首页</a></li>";
        } else {
            $homepage .= "<li><a href='javascript:;' style='color:#ccc'>首  页</a></li>";
        }

        //获得上一页和下一页的链接
        if ($cur_page != 1) {
            $prepage .= "<li class='lastpage'><a href='" . $purl . "page=$prepagenum'>上一页</a></li>\r\n";
        } else {
            $prepage .= "<li class='lastpage'><a href='javascript:;' style='color:#ccc'>上一页</a></li>\r\n";
        }

        //下一页,未页的链接
        if ($cur_page != $totalpage && $totalpage > 1) {
            $nextpage .= "<li class='nextpage'><a href='" . $purl . "page=$nextpagenum'>下一页</a></li>\r\n";
        } else {
            $nextpage .= "<li class='nextpage'><a href='javascript:;' style='color:#ccc'>下一页</a></li>\r\n";
        }

        if ($cur_page != $totalpage) {
            $lastpage .= "<li><a href='" . $purl . "page=$totalpage' title='尾页'>尾  页</a></li>";
        } else {
            $lastpage .= "<li><a href='javascript:;' style='color:#ccc'>尾  页</a></li>";
        }

        //num 链接
        $num_start = $cur_page - 2;
        $num_end = $cur_page + 2;
        if ($num_start < 1) {
            $num_end = $num_end + (1 - $num_start);
            $num_start = 1;
        }
        if ($num_end > $totalpage) {
            $num_start = $num_start - ($num_end - $totalpage);
            $num_end = $totalpage;
        }
        if ($num_start < 1)
            $num_start = 1;

        if ($num_start > 1) {
            $numpage .= "<li class='pageEllipsis'>...</li>";
        }
        //echo $num_start.'=='.$num_end.'d=='.$cur_page;
        for ($i = $num_start; $i <= $num_end; $i++) {
            if ($i == $cur_page) {
                $numpage .= "<li><a href='" . $purl . "page=$i' title='第" . $i . "页' class='cur'>$i</a></li>";
            } else {
                $numpage .= "<li><a href='" . $purl . "page=$i' title='第" . $i . "页'>$i</a></li>";
            }
        }
        if ($num_end < $totalpage) {
            $numpage .= "<li class='pageEllipsis'>...</li>";
        }

        //option链接
        $optionlist = '';
        $optionlist = "<li class='selpage'><select name='sldd' onchange='location.href=this.options[this.selectedIndex].value;'>\r\n";
        for ($mjj = 1; $mjj <= $totalpage; $mjj++) {
            if($mjj<=100){
               if ($mjj == $cur_page) {
                    $optionlist .= "<option value='" . $purl . "page=$mjj' selected>第" . $mjj . "页</option>\r\n";
                } else {
                    $optionlist .= "<option value='" . $purl . "page=$mjj'>第" . $mjj . "页</option>\r\n";
                } 
            }
        }
        $optionlist .= "</select></li>\r\n";

        if ($total_result > $page_size) {
            $plist = '<ul class="pager">';
            if (preg_match('/home/i', $listitem))
                $plist .= $homepage;
            if (preg_match('/pre/i', $listitem))
                $plist .= $prepage;
            if (preg_match('/num/i', $listitem))
                $plist .= $numpage;
            if (preg_match('/option/i', $listitem))
                $plist .= $optionlist;
            if (preg_match('/next/i', $listitem))
                $plist .= $nextpage;
            if (preg_match('/last/i', $listitem))
                $plist .= $lastpage;
            if (preg_match('/total/i', $listitem))
                $plist .= "<li class='pageRemark'><a href='javascript:;' style='color:#333'>共<b>" . $total_result . "</b> 条记录&nbsp;&nbsp;<b>" . $cur_page . "/" . $totalpage . "</b> 页</a></li>";
            $plist .= '</ul>';
        }
        return $plist;
    }

    /**
     *  获得当前的页面文件的url
     *
     * @access    public
     * @return    string
     */
    private static function getCurUrl() {
        if (!empty($_SERVER['REQUEST_URI'])) {
            $nowurl = $_SERVER['REQUEST_URI'] . "&";
        } else {
            $nowurl = $_SERVER['PHP_SELF'] . "?";
        }
        return $nowurl;
    }

    /**
     * 获取单条数据
     * @param string $table_name 表名
     * @param string $where 条件
     * @param array $sqlarr 数组
     * @param string $order 排序
     * @return array 
     */
    public static function getOne($table_name, $where = '1=1', $sqlarr, $order) {
        $selstr = empty($sqlarr) ? '*' : implode(',', $sqlarr);
        $sql = 'SELECT ' . $selstr . ' FROM ' . $table_name . $where . $order;
        return Query::sqlselone($sql);
    }

    /**
     * 获取数据列表
     * @param string $table_name 表名
     * @param string $where 条件
     * @param array $sqlarr 数组
     * @param string $order 排序
     * @param string $page 当前页
     * @param string $page_size 每页显示条数
     * @param string $ispage 是否分页
     * @return array 
     */
    public static function getList($table_name, $where = ' WHERE 1=1', $sqlarr, $order, $page = 1, $page_size = 10, $ispage = 1, $groupby = '', $pagenum = 0) {
        $selstr = empty($sqlarr) ? '*' : implode(',', $sqlarr);
        $limit = ' LIMIT ' . ($page - 1) * $page_size . ', ' . $page_size;
        $sql = 'SELECT ' . $selstr . ' FROM ' . $table_name . $where . $groupby . $order . $limit;
        $data = Query::sqlsel($sql);
        if ($ispage) {
            $data2 = Query::sqlsel('SELECT ' . $selstr . ' FROM ' . $table_name . $where . $groupby . $order);
            $total = $groupby ? count($data2) : self::get_total_count($table_name, $where);
            $pager = Pager::getPageList($page, $total, $page_size);
            return array('data' => $data, 'pager' => $pager);
        } else {
            return $data;
        }
    }

    /**
     * 获取总记录数
     * @param string $table_name 表名
     * @param string $where 条件
     * @return array 
     */
    private static function get_total_count($table_name, $where = '1=1') {
        $sql = 'SELECT COUNT(*) AS total FROM ' . $table_name . $where;
        $res = Query::sqlselone($sql);
        return empty($res) ? 0 : $res['total'];
    }

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DbMy
 *
 * @author Administrator
 */

namespace core\db;

class DbMysqli {

    //put your code here
    private static $_instance;
    public $link;

    public static function getInstance($arr) {
        $key = md5(json_encode($arr));
        if (!isset(self::$_instance[$key]) || !(self::$_instance[$key] instanceof self)) {
            self::$_instance[$key] = new self($arr);
        }
        return self::$_instance[$key];
    }

    private function __construct($arr) {
        if (!isset($arr['port'])) {
            $arr['port'] = 3306;
        }
        $this->link = mysqli_connect($arr['dbhost'], $arr['dbuser'], $arr['dbpw'], $arr['dbname'], $arr['port']);
        if (!$this->link) {
            die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
        }
        mysqli_set_charset($this->link, $arr['charset']);
    }

    private function escape($arr) {
        if (!is_array($arr)) {
            return mysqli_real_escape_string($this->link, $arr);
        }
        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                $value = $this->escape($value);
            } else {
                $arr[$key] = mysqli_real_escape_string($this->link, $value);
            }
        }
        return $arr;
    }

    /**
     * 循环查询记录
     *
     * @param query $query
     * @param string $result_type
     * @return array
     */
    public function select($table, $where = array(), $selarr = array(), $order = array(), $limit = '', $group = '') {
        $sql = $this->selsql($table, $where, $selarr, $order, $limit, $group);
        $result = mysqli_query($this->link, $sql, MYSQLI_USE_RESULT);
        $data = array();
        if ($result) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $data[] = $row;
            }
            mysqli_free_result($result);
        }
        return $data;
    }

    public function selectpage($table, $where = array(), $page = 1, $pagezize = 20, $selarr = array(), $order = array(), $limit = '', $group = '') {
        $arr = $this->selectone($table, $where, 'count(*) as num', $order, $group);
        $rsnum = intval($arr['num']);
        $pagenum = ceil($rsnum / $pagezize);
        if ($page > $pagenum) {
            $page = $pagenum;
        }
        if ($page < 1) {
            $page = 1;
        }
        $start = ($page - 1) * $pagezize;
        $limit = $start . ',' . $pagezize;
        $sql = $this->selsql($table, $where, $selarr, $order, $limit, $group);
        $result = mysqli_query($this->link, $sql, MYSQLI_USE_RESULT);
        $data = array();
        if ($result) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $data[] = $row;
            }
            mysqli_free_result($result);
        }
        $pagestr = \Common\Pager::getPageList($page, $rsnum, $pagezize);
        $result = array('data' => $data, 'rsnum' => $rsnum, 'page' => $page, 'pagezize' => $pagezize, 'pagestr' => $pagestr);
        return $result;
    }

    public function sqlpage($sql, $page, $pagezize) {
        $rsnum = 0;
        if (preg_match('#select (.+?) from#ims', $sql, $arr)) {
            $contsql = str_replace($arr[1], 'count(*) as num', $sql);
            $arr = $this->sqlselone($contsql);
            $rsnum = intval($arr['num']);
        }
        $pagenum = ceil($rsnum / $pagezize);
        if ($page > $pagenum) {
            $page = $pagenum;
        }
        if ($page < 1) {
            $page = 1;
        }
        $start = ($page - 1) * $pagezize;
        $sql = $sql . ' limit ' . $start . ',' . $pagezize;
        $data = $this->sqlsel($sql);
        $pagestr = \Common\Pager::getPageList($page, $rsnum, $pagezize);
        $result = array('data' => $data, 'rsnum' => $rsnum, 'page' => $page, 'pagezize' => $pagezize, 'pagestr' => $pagestr);
        return $result;
    }

    /**
     * 查询一条记录
     * @param type $table
     * @param type $where
     * @param type $selarr
     * @param type $order
     * @param type $group
     * @return type
     */
    public function selectone($table, $where = array(), $selarr = array(), $order = array(), $group = '') {

        $sql = $this->selsql($table, $where, $selarr, $order, '0,1', $group);
        $result = mysqli_query($this->link, $sql, MYSQLI_USE_RESULT);
        $data = array();
        if ($result) {
            $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
            mysqli_free_result($result);
        }
        return $data;
    }

    public function commitstart() {
        mysqli_autocommit($this->link, FALSE);
    }

    public function commit() {
        $r = mysqli_commit($this->link);
        mysqli_autocommit($this->link, TRUE);
        return $r;
    }

    public function rollback() {
        $r = mysqli_rollback($this->link);
        mysqli_autocommit($this->link, TRUE);
        return $r;
    }

    private function selsql($table, $where = array(), $selarr = array(), $order = array(), $limit = '', $group = '') {
        $where = $this->escape($where);

        $selarr = $this->escape($selarr);
        $selstr = !empty($selarr) && is_array($selarr) ? implode(',', $selarr) : $selarr;
        if (is_array($selarr) && !empty($selarr)) {
            $selstr = implode(',', $selarr);
        } elseif (!$selarr) {
            $selstr = '*';
        } else {
            $selstr = $selarr;
        }
        $limitstr = $limit != '' ? ' limit ' . $limit : '';
        $groupstr = $group != '' ? ' group by ' . $group . ' ' : '';
        $orderstr = '';
        if (!empty($order)) {
            $orderstr = ' order by ';
            foreach ($order as $value) {
                if (!is_array($value)) {
                    $orderstr.=$value . ' asc';
                } else {
                    $orderstr.=$value[0] . ' ' . (isset($value[1]) ? $value[1] : 'asc');
                }
            }
        }
        $wherestr = ' ';
        if (($where)) {

            $bw = new bwhere($where);
            $wherestr = $bw->build();
        }
        $sql = 'select ' . $selstr . ' from ' . $table . $wherestr . $groupstr . $orderstr . $limitstr;

        return $sql;
    }

    /**
     * 查询最近的id
     * @return type
     */
    public function insert_id() {
        return mysqli_insert_id($this->link);
    }

    /**
     * 插入数据
     * @param type $table
     * @param type $inarr
     * @param type $replace
     */
    public function insert($table, $inarr, $replace = false) {
        $inarr = $this->escape($inarr);
        $sql = $replace ? 'replace into ' : 'insert into ';
        $sql.=$table . ' set ';
        $s = '';
        foreach ($inarr as $key => $value) {
            $sql.=$s . '`' . $key . '`=\'' . $value . '\'';
            $s = ',';
        }
        $res = mysqli_query($this->link, $sql);
        if($res && $this->insert_id()>0){
            return $this->insert_id();
        }
        return $res;
    }

    /**
     * 批量插入数据
     * @param type $table
     * @param type $inarr
     * @param type $replace
     */
    public function inserts($table, $inarrs, $replace = false) {
        $inarrs = $this->escape($inarrs);
        $sql = $replace ? 'replace into ' : 'insert into ';
        $keyarr = array_keys($inarrs[0]);
        $sql.=$table . ' (`' . implode('`,`', $keyarr) . '`) values ';
        $s='';
        foreach ($inarrs as $arr) {
            $str = implode("','", $arr);
            $sql.=$s.'(\'' . $str . '\')';
            $s=',';
        }
        //echo $sql;
        mysqli_query($this->link, $sql);
        return $this->insert_id();
    }

    /**
     * 修改记录
     * @param type $table
     * @param type $updarr
     * @param type $where
     * @param type $limit
     */
    public function update($table, $updarr, $where = array(), $limit = 0) {
        $updarr = $this->escape($updarr);
        $bw = new bwhere($this->escape($where));
        $where = $bw->build();
        $limitstr = $limit ? ' limit ' . $limit : '';
        $sql = 'update `' . $table . '` set ';
        $s = '';
        foreach ($updarr as $key => $value) {
            $sql.=$s . '`' . $key . '`=\'' . $value . '\'';
            $s = ',';
        }
        $sql.=$where . $limitstr;
        mysqli_query($this->link, $sql);
        return mysqli_affected_rows($this->link);
    }

    /**
     * 删除记录
     * @param type $table
     * @param type $where
     * @param type $limit
     */
    public function delete($table, $where = array(), $limit = '') {
        $bw = new bwhere($this->escape($where));
        $where = $bw->build();
        $limitstr = $limit ? ' limit ' . $limit : '';
        $sql = 'delete from `' . $table . '` ';
        $sql.=$where . $limitstr;
        mysqli_query($this->link, $sql);
        return mysqli_affected_rows($this->link);
    }

    public function sqlsel($sql) {
        $result = mysqli_query($this->link, $sql, MYSQLI_USE_RESULT);
        $data = array();
        if ($result) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $data[] = $row;
            }
            mysqli_free_result($result);
        }
        return $data;
    }

    public function sqlselone($sql) {
        $result = mysqli_query($this->link, $sql, MYSQLI_USE_RESULT);
        $data = array();
        if ($result) {
            return mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
        return array();
    }

    public function sqlquery($sql) {
        return mysqli_query($this->link, $sql, MYSQLI_USE_RESULT);
    }
    
	public function getError()
    {
        return mysqli_error($this->link);
    }

}

class bwhere {

    private $wherearr = array();

    public function __construct($wherearr = array()) {
        $this->wherearr = $wherearr;
    }

    public function build() {
        $where = ' where 1';
        if (!is_array($this->wherearr) || empty($this->wherearr)) {
            return '';
        }
        foreach ($this->wherearr as $key => $value) {
            if (!is_array($value)) {
                $where.=' and `' . $key . '`=\'' . $value . '\'';
            } else {
                $str = $this->$value[0]($value[1]);
                $where.=' and `' . $key . '`' . $str;
            }
        }
        return $where;
    }

    private function between($data) {
        return ' between (' . $data[0] . ',' . $data[1] . ')';
    }

    private function in($data) {
        return ' in (\'' . implode('\',\'', $data) . '\')';
    }

    private function gt($data) {
        return ' >' . $data;
    }

    private function lt() {
        return ' <' . $data;
    }

    public function __call($name, $arguments) {
        ;
    }

}

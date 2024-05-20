<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model\User;

use Common\Cache;
use Common\Query;

class Group {
    /**
     * 添加分组信息
     * @param type $name
     * @param type $memo
     * @param type $add_time
     * @return type
     */
    public static function add($name,$memo,$add_time){
        $inarr['name'] = $name;
        $inarr['add_time'] =strtotime($add_time);
        $inarr['memo'] = $memo;
        $res = \Common\Query::insert('`group`', $inarr);
        return $res;
    }
    
    /**
     * 更新分组信息
     * @param type $id
     * @param type $updarr
     * @return type
     */
    public static function edit($updarr,$id){
        if($updarr['add_time'])
        {
            $updarr['add_time']= strtotime($updarr['add_time']);
        }
        return \Common\Query::update('group', $updarr, array('id'=>$id));
    }
    
    
    
    /**
     * 根据ID获得分组信息
     * @param type $id
     * @return type
     */
    public static function getById($id) {
        $row = \Common\Query::selone('`group`', array('id'=> intval($id)));
        if($row){
            return $row;
        }
        return array();
    }
    
    public static function getList()
    {
        $rows= \Common\Query::sqlsel("select * from `group` order by add_time asc");
        $list=array();
        foreach($rows as $row)
        {
            $list[$row['id']]=$row;
        }
        return $list;
    }
    
    public static function idToName($group_id)
    {
        $arr_names = array();
        if(!empty($group_id)){
            $arr_ids = explode(',', $group_id);
            $group_list = self::getList();
            foreach ($arr_ids as $gid) {
                $arr_names[] = $group_list[$gid]['name'];
            }
        }
        return implode(',', $arr_names);
    }
    /**
     * 根据ID删除分组
     * @param type $id
     * @return type
     */
    public static function del($id){
        $id=intval($id);
        if(empty($id))
        {
            return array('ret'=>1,'msg'=>'ID不能为空');
        }
        
        $res= UserInfo::isGroupExist($id);
        if($res)
        {
            return array('ret'=>1,'msg'=>'用户管理里已引用该分组,请前往调整后再删除!');
        }
        
        $res= \Model\Admin\Finance::isGroupExist($id);
        if($res)
        {
            return array('ret'=>1,'msg'=>'收款账户设置已引用该分组,请前往调整后再删除!');
        }
        $res = \Common\Query::delete('group', array('id'=> $id));
        if($res<1)
        {
            return array('ret'=>1,'msg'=>'删除失败!');
        }
        return array('ret'=>0,'msg'=>'删除成功!');
    }
}
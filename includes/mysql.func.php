<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/16
 * Time: 15:44
 */
if(!defined('IN_TG')){
    exit('Access Defined');
}



function _connect(){
    global $_conn;
   if (! $_conn=@mysql_connect(DB_HOST,DB_USER,DB_PWD)){
       exit('数据库连接失败');
   }
}

function _select_db(){
    if (!mysql_select_db(DB_NAME)){
        exit('找不到指定的数据库');
    }
}

function _set_names(){
    if(!mysql_query('SET NAMES UTF8')){
        exit('字符集错误');
    }
}


function _query($_sql){
    if (!$_result=mysql_query($_sql)){
        exit('SQL执行失败'.mysql_error());
    }
    return $_result;
}


function _fetch_array($_sql){
    return mysql_fetch_array(_query($_sql),MYSQL_ASSOC);
}

function _fetch_array_list($_result){
    return mysql_fetch_array($_result,MYSQL_ASSOC);
}

function _num_rows($_result){
    return mysql_num_rows($_result);
}



function _affected_rows(){
    return mysql_affected_rows();
}

function _free_result($_result){
    @mysqli_free_result($_result);

}

function _insert_id(){
    return mysql_insert_id();
}


function _is_repeat($_sql,$_info){
    if (_fetch_array($_sql)){
        _alert_back($_info);
    }
}

function _close(){
    if (!mysql_close()){
        exit('关闭异常');
    }
}



?>
<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/13
 * Time: 15:53
 */
if(!defined('IN_TG')){
    exit('Access Defined');
}
//设置字符编码
header('Content-Type:text/html;charset=utf-8');
define('ROOT_PATH',substr(dirname(__FILE__),0,-8));

define('GPC',get_magic_quotes_gpc());
if(PHP_VERSION<'4.1.0'){
    exit('Version is too Low!');
}

require ROOT_PATH.'includes/global.func.php';
require ROOT_PATH.'includes/mysql.func.php';


define('START_TIME',_runtime());

define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PWD','123456');
define('DB_NAME','testguest');


_connect();
_select_db();
_set_names();

//短信提醒
$_message=_fetch_array("SELECT 
                         COUNT(tg_id) 
                         AS 
                         count 
                         FROM 
                         tg_message 
                         WHERE 
                         tg_state=0
                         AND
                         tg_touser='{$_COOKIE['username']}'

");
if(empty($_message['count'])){
    $GLOBALS['message']='<strong class="noread"><a href="member_message.php">(0)</a></strong>';
}else{
    $GLOBALS['message']='<strong class="read"><a href="member_message.php">('.$_message['count'].')</a></strong>';
}

//网站系统设置初始化
if(!! $_rows=_fetch_array("SELECT 
                  tg_webname,
                  tg_article,
                  tg_blog,
                  tg_photo,
                  tg_skin,
                  tg_string,
                  tg_post,
                  tg_re,
                  tg_code,
                  tg_register
                FROM 
                   tg_system
                WHERE 
                   tg_id=1
                LIMIT 1
                ")){
    $_system=array();
     $_system['webname']=$_rows['tg_webname'];
    $_system['article']=$_rows['tg_article'];
    $_system['blog']=$_rows['tg_blog'];
    $_system['photo']=$_rows['tg_photo'];
    $_system['skin']=$_rows['tg_skin'];
    $_system['post']=$_rows['tg_post'];
    $_system['re']=$_rows['tg_re'];
    $_system['code']=$_rows['tg_code'];
    $_system['register']=$_rows['tg_register'];
    $_system['string']=$_rows['tg_string'];

    $_system=_html($_system);
}else{
    exit('系统表异常请管理员检查');
}




?>


<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/19
 * Time: 19:46
 */
session_start();
define('IN_TG',true);

define('SCRIPT','member_flower');
require dirname(__FILE__).'/includes/common.inc.php';
if(!isset($_COOKIE['username'])){
    _alert_back('请先登录');
}
if($_GET['action']=='delete'&& isset($_POST['ids'])){
   $_clean=array();
    $_clean['ids']=_mysql_string(implode(',',$_POST['ids']));
if (!!$_rows2=_fetch_array("SELECT
                                   tg_uniqid
                                FROM
                                   tg_user
                                WHERE
                                   tg_username='{$_COOKIE['username']}'LIMIT 1")) {


    _uniqid($_rows2['tg_uniqid'], $_COOKIE['uniqid']);
    _query("DELETE
                      FROM
                         tg_flower
                      WHERE
                         tg_id
                      IN({$_clean['ids']})
                      ");
    if (_affected_rows()) {
        _close();
//跳转
        _location('恭喜你，花朵删除成功', 'member_message.php');
    }else{
        _close();
//跳转
        _alert_back('花朵删除失败');

    }
}else{
    _alert_back('非法登陆');
}
}

global $_pagenum,$_pagesize;
_page("SELECT 
                   tg_id 
                FROM 
                   tg_flower 
                WHERE 
                   tg_touser='{$_COOKIE['username']}'",10);

$_result=_query("SELECT 
                         tg_id,
                         tg_flower,
                         tg_fromuser,
                         tg_content,
                         tg_date 
                      FROM 
                         tg_flower 
                      WHERE 
                        tg_touser='{$_COOKIE['username']}'
                      ORDER BY 
                         tg_date 
                      DESC 
                         LIMIT $_pagenum,$_pagesize");





?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" " http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns=" http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <?php
    require ROOT_PATH.'includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/member_message.js"></script>
   </head>
<body>
<?php
require ROOT_PATH.'includes/header.inc.php';
?>
<div id="member">
    <?php require ROOT_PATH.'includes/member.inc.php';?>
    <div id="member_main">
        <h2>花朵管理中心</h2>
        <form method="post" action="?action=delete">
        <table cellspacing="1">
            <tr><th>送花人</th><th>花朵数目</th><th>送花感言</th><th>时间</th><th>操作</th></tr>
      <?php

            $_html =array();
      $_html['count']=0;
      while(!!$_rows=_fetch_array_list($_result)){

          $_html['id']=$_rows['tg_id'];
          $_html['fromuser']=$_rows['tg_fromuser'];
          $_html['content']=$_rows['tg_content'];
          $_html['flower']=$_rows['tg_flower'];
          $_html['date']=$_rows['tg_date'];
          $_html['count']+=$_html['flower'];
          $_html=_html($_html);
          ?>
          <tr><td><?php echo  $_html['fromuser']?></td><td><?php echo $_html['flower']?>朵</a></td><td><?php echo  _title($_html['content'])?></td><td><?php echo  $_html['date']?></td><td><input name="ids[]" value="<?php echo $_html['id']?>" type="checkbox"/></td></tr>

       <?php
      }
     // _free_result($_result);
      ?>
            <tr><td colspan="5">共<strong><?php echo $_html['count']?></strong>朵花</td></tr>
            <tr><td clospan="5"><label for="all">全选<input type="checkbox" name="chkall" id="all"/></label><input type="submit" value="批删除"/></td></tr>

        </table>   </form>
        <?php
        _paging(1);
        ?>

    </div>
<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>

<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/19
 * Time: 19:46
 */
session_start();
define('IN_TG',true);

define('SCRIPT','manage_job');
require dirname(__FILE__).'/includes/common.inc.php';
_manage_login();
_page("SELECT tg_id FROM tg_user",15);
if ($_GET['action']=='add') {
    if (!!$_rows = _fetch_array("SELECT 
                                   tg_uniqid  
                                FROM 
                                   tg_user 
                                WHERE 
                                   tg_username='{$_COOKIE['username']}'LIMIT 1")
    ) {
        _uniqid($_rows['tg_uniqid'], $_COOKIE['uniqid']);
    }

    $_clean = array();
    $_clean['username'] = $_POST['manage'];
    $_clean = _mysql_string($_clean);
//
    _query("UPDATE tg_user SET tg_level=1 WHERE tg_username='{$_clean['username']}'");
    if (_affected_rows() == 1) {
        _close();
//跳转
        _location('恭喜你，管理员添加成功', SCRIPT . '.php');
    } else {
        _close();
//跳转
        _location('不存在此用户或者为空', SCRIPT . '.php');
    }

}
//辞职
if ($_GET['action']=='job'&&isset($_GET['id'])){
    if (!!$_rows=_fetch_array("SELECT 
                                   tg_uniqid  
                                FROM 
                                   tg_user 
                                WHERE 
                                   tg_username='{$_COOKIE['username']}'LIMIT 1")) {

        _uniqid($_rows['tg_uniqid'], $_COOKIE['uniqid']);

        _query("UPDATE tg_user SET tg_level=0 WHERE tg_username='{$_COOKIE['username']}' AND tg_id='{$_GET['id']}'");
        if (_affected_rows() == 1) {
            _close();
//跳转
            _session_destroy();
            _location('辞职成功', 'index.php');
        } else {
            _close();
//跳转
            _location('辞职失败', SCRIPT . '.php');
        }
    } else{
        _alert_back('非法登陆');
}
}


global $_pagenum,$_pagesize;
$_result=_query("SELECT 
                     tg_id,
                      tg_username,
                  tg_email,
                  tg_reg_time
                      FROM 
                         tg_user 
                         WHERE
                         tg_level=1
                      ORDER BY 
                         tg_reg_time 
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
    <link rel="stylesheet" type="text/css" href="styles/1/manage_job.css.css"  />

    <script type="text/javascript" src="js/member_message.js"></script>
   </head>
<body>
<?php
require ROOT_PATH.'includes/header.inc.php';
?>
<div id="member">
    <?php require ROOT_PATH.'includes/manage.inc.php';?>
    <div id="member_main">
        <h2>会员列表中心</h2>
        <table cellspacing="1">
            <tr><th>ID号</th><th>会员名</th><th>邮件</th><th>注册时间</th><th>操作</th></tr>
<?php
$_html =array();
while(!!$_rows=_fetch_array_list($_result)){

$_html['id']=$_rows['tg_id'];
$_html['username']=$_rows['tg_username'];
$_html['email']=$_rows['tg_email'];
$_html['reg_time']=$_rows['tg_reg_time'];
$_html=_html($_html);
if ($_COOKIE['username']==$_html['username']){
    $_html['job_html']='<a href="manage_job.php?action=job&id='.$_html['id'].'">辞职</a>';
}else{
    $_html['job_html']='无权操作';
}
?>
          <tr><td><?php echo  $_html['id']?></td>
              <td><?php echo $_html['username'] ?></td>
              <td><?php echo  $_html['email']?></td>
              <td><?php echo $_html['reg_time']?></td>
              <td><?php echo $_html['job_html']?></td></tr>

<?php }?>
      </table>
            <form method="post" action="manage_job.php?action=add">
                <input type="text" name="manage" class="text"/><input type="submit" value="管理员">
            </form>
        </form>
        <?php
        _free_result($_result);
        _paging(2);

        ?>

    </div>
</div>
<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>

<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/19
 * Time: 19:46
 */
session_start();
define('IN_TG',true);

define('SCRIPT','manage_member');
require dirname(__FILE__).'/includes/common.inc.php';
_manage_login();
_page("SELECT tg_id FROM tg_user",15);

global $_pagenum,$_pagesize;
$_result=_query("SELECT 
                     tg_id,
                      tg_username,
                  tg_email,
                  tg_reg_time
                      FROM 
                         tg_user 
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
        <form method="post" action="?action=delete">
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

?>
          <tr><td><?php echo  $_html['id']?></td>
              <td><?php echo $_html['username'] ?></td>
              <td><?php echo  $_html['email']?></td>
              <td><?php echo $_html['reg_time']?></td>
              <td><a href="?action=del&id=<?php echo $_html['id']?>">[删][修]</a></td></tr>

<?php }?>
      </table>   </form>
<?php
_free_result($_result);
_paging(2);

?>

    </div>
<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>

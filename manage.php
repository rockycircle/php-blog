<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/18
 * Time: 16:22
 */
session_start();
define('IN_TG',true);

define('SCRIPT','manage');
require dirname(__FILE__).'/includes/common.inc.php';
//是否正常登陆
_manage_login();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" " http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns=" http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <?php
    require ROOT_PATH.'includes/title.inc.php';
    ?>
</head>
<body>
<?php
require ROOT_PATH.'includes/header.inc.php';
?>
<div id="member">
<?php require ROOT_PATH.'includes/manage.inc.php';?>
    <div id="member_main">
        <h2>后台管理中心</h2>
        <dl>
            <dd>服务器主机名称：<?php echo $_SERVER['SERVER_NAME']?></dd>
            <dd>通信协议名称/版本：<?php echo $_SERVER['SERVER_PROTOCOL']?></dd>
            <dd>服务器ip：<?php echo $_SERVER['SERVER_ADDR']?></dd>
            <dd>客户端ip：<?php echo $_SERVER['REMOTE_ADDR']?></dd>
            <dd>服务器端口：<?php echo $_SERVER['SERVER_PORT']?></dd>
            <dd>客户端端口：<?php echo $_SERVER['REMOTE_PORT']?></dd>
            <dd>管理员邮箱：<?php echo $_SERVER['SERVER_ADMIN']?></dd>


        </dl>
    </div>
</div>
<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>


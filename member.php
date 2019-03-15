<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/18
 * Time: 16:22
 */
session_start();
define('IN_TG',true);

define('SCRIPT','member');
require dirname(__FILE__).'/includes/common.inc.php';
//是否正常登陆
if(isset($_COOKIE['username'])){
   //获取数据
    $_rows=_fetch_array("SELECT 
                   tg_username,
                   tg_sex,tg_face,
                   tg_email,tg_url,
                   tg_qq,tg_level,
                   tg_reg_time 
                FROM 
                   tg_user 
                WHERE 
                   tg_username='{$_COOKIE['username']}'
                LIMIT 1
                ");
if($_rows){
//    $_username = $_rows['tg_username'];
//    $_sex = $_rows['tg_sex'];
    $_html=array();
    $_html['username']=$_rows['tg_username'];
    $_html['sex']=$_rows['tg_sex'];
    $_html['face']=$_rows['tg_face'];
    $_html['email']=$_rows['tg_email'];
    $_html['url']=$_rows['tg_url'];
    $_html['qq']=$_rows['tg_qq'];
    $_html['reg_time']=$_rows['tg_reg_time'];
    switch ($_rows['tg_level']){
        case 0:
            $_html['level']='普通会员';
            break;
        case 1:
            $_html['level']='管理员';
            break;
        default:$_html['level']='出错啦';
    }
    $_html=_html($_html);
}else{
_alert_back('此用户不存在');
}
}else{
    echo '非法登陆';
}


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
<?php require ROOT_PATH.'includes/member.inc.php';?>
    <div id="member_main">
        <h2>会员管理中心</h2>
        <dl>
            <dd>性   别：<?php echo $_html['username']?></dd>
            <dd>性   别：<?php echo $_html['sex']?></dd>
            <dd>头   像：<?php echo $_html['face']?></dd>
            <dd>电子邮件：<?php echo $_html['email']?></dd>
            <dd>主   页：<?php echo $_html['url']?></dd>
            <dd>Q    Q：<?php echo $_html['qq']?></dd>
            <dd>注册时间：<?php echo $_html['reg_time']?></dd>
            <dd>身   份：<?php echo $_html['level']?></dd>


        </dl>
    </div>
</div>
<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>


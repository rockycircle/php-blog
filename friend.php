<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/19
 * Time: 15:59
 */
session_start();
define('IN_TG',true);

define('SCRIPT','friend');
require dirname(__FILE__).'/includes/common.inc.php';
if(!isset($_COOKIE['username'])){
_alert_close('请先登录');
}
//添加好友
if($_GET['action']=='add') {
    _check_code($_POST['code'], $_SESSION['code']);
    if (!!$_rows = _fetch_array("SELECT 
                                  tg_uniqid 
                               FROM 
                                  tg_user 
                               WHERE 
                                  tg_username='{$_COOKIE['username']}'
                               LIMIT 1"))
    {
        _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
    }
    include ROOT_PATH.'includes/check.func.php';
    $_clean=array();
    $_clean['touser']=$_POST['touser'];
    $_clean['fromuser']=$_COOKIE['username'];
    $_clean['content']=_check_content($_POST['content']);
    $_clean=_mysql_string($_clean);

    if ($_clean['touser']==$_clean['fromuser']){
        _alert_close('不要添加自己');
    }
//数据库验证手否已经添加
if(!!$_rows =_fetch_array("SELECT
                               tg_id
                               FROM
                               tg_friend
                               WHERE
                               (tg_touser='{$_clean['touser']}' AND tg_fromuser='{$_clean['fromuser']}')
                               OR 
                               (tg_touser='{$_clean['fromuser']}' AND tg_fromuser='{$_clean['touser']}')
                               LIMIT 1
                               
                                ")) {
    _alert_close('你们已经是好友了！无需重复添加');

    }else{
//添加好友信息
_query("INSERT INTO tg_friend(
                    tg_touser,
                    tg_fromuser,
                    tg_content,
                    tg_date
)
                VALUES (
                '{$_clean['touser']}',
                '{$_clean['fromuser']}',
                '{$_clean['content']}',
                NOW()
                )
");
    if (_affected_rows()==1) {
        _close();
//跳转
        //_session_destroy();
        _alert_close('好友添加成功，请等待验证');
    }else{
        _close();
//跳转
        //_session_destroy();
        _alert_back('好友添加失败');

    }
    }
}
if (isset($_GET['id'])){
    if (!!$_rows=_fetch_array("SELECT 
                          tg_username 
                          FROM 
                          tg_user 
                          WHERE 
                          tg_id='{$_GET['id']}' 
                          LIMIT 1")){
$_html=array();
$_html['touser']=$_rows['tg_username'];
$_html = _html($_html);
    }else{
        _alert_close('不存在此用户');
    }
}else{
    _alert_close('非法操作');
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" " http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns=" http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <?php
    require ROOT_PATH.'includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/code.js"></script>
    <script type="text/javascript" src="js/message.js"></script>
</head>
<body>

<div id="message">
    <h3>添加好友</h3>
 <form  method="post" action="?action=add">
     <input type="hidden" name="touser" value="<?php echo $_html['touser']?>"/>
    <dl>
        <dd><input type="text" readonly="readonly" value="TO:<?php echo $_html['touser']?>" class="text"/></dd>
        <dd><textarea name="content">我非常想和你交朋友!</textarea></dd>
        <dd>验 证 码：<input type="text" name="code" class="text yzm"/><img src="code.php" id="code" /><input type="submit" class="submit" value="添加好友" /></dd>
    </dl>
 </form>
</div>
<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>


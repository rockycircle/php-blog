<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/17
 * Time: 13:34
 */
session_start();
define('IN_TG',true);

define('SCRIPT','photo_add_img');
require dirname(__FILE__).'/includes/common.inc.php';
//这张页面必须是会员才能登陆
if (!$_COOKIE['username']){
    _alert_back('非法登陆');
}
//保存图片入表
if($_GET['action']=='addimg'){
if (!!$_rows=_fetch_array("SELECT 
                                   tg_uniqid,
                                    tg_article_time
                                FROM 
                                   tg_user 
                                WHERE 
                                   tg_username='{$_COOKIE['username']}'LIMIT 1")) {
    _uniqid($_rows['tg_uniqid'], $_COOKIE['uniqid']);
include 'includes/check.func.php';
    $_clean = array();
$_clean['name']=_check_dir_name($_POST['name'],2,20);
$_clean['url'] = _check_photo_url($_POST['url']);
$_clean['content']=$_POST['content'];
    $_clean['sid']=$_POST['sid'];
$_clean=_mysql_string($_clean);
//写入数据库
    _query("INSERT INTO tg_photo(
                                tg_name,
                                tg_url,
                                tg_content,
                                tg_sid,
                                tg_date
                             )VALUES (
                             '{$_clean['name']}',
                             '{$_clean['url']}',
                             '{$_clean['content']}',
                             '{$_clean['sid']}',
                             NOW()                             
                             )");
    if (_affected_rows()==1) {
        _close();
        _alert_close('图片添加成功','photo_show.php?id='.$_clean['sid']);
    }else{
        _close();
        _alert_back('图片添加失败');

    }
}else{
    _alert_back('非法登陆');
}
}


//取值
if(isset($_GET['id'])){
    if(!!$_rows=_fetch_array("SELECT
                                   tg_id,
                                   tg_dir
                                   FROM
                                   tg_dir
                                   WHERE
                                   tg_id='{$_GET['id']}'
                                   LIMIT
                                   1
    ")){
        $_html=array();
        $_html['id']=$_rows['tg_id'];
        $_html['dir']=$_rows['tg_dir'];
        $_html=_html($_html);
    }else{
        _alert_back('不存在此相册');
    }
}else{
    _alert_back('非法操作');
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" " http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns=" http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <?php
    require ROOT_PATH.'includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/photo_add_img.js"></script>
</head>
<body>
<?php
require ROOT_PATH.'includes/header.inc.php';
?>

<div id="photo">
    <h2>添加上传图片</h2>
    <form method="post" action="?action=addir">
        <input type="hidden" name="sid" value="<?php echo $_html['id']?>">
    <dl>
        <dd>图片名称：<input type="text"name="name"class="text"></dd>
        <dd>图片地址：<input type="text"name="url" readonly="readonly" class="text"/><a href="javascript:;" id="up">上传</a></dd>
        <dd id="pass">相册密码：<input type="text"name="password"class="text"></dd>
        <dd>图片描述：<textarea name="content"></textarea></dd>
        <dd><input type="submit" value="添加目录" class="submit"/></dd>

    </dl>
    </form>
</div>

<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>

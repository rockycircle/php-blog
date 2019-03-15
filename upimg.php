<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/13
 * Time: 20:54
 */
define('IN_TG',true);

define('SCRIPT','upimg');
require dirname(__FILE__).'/includes/common.inc.php';
//会员进入
if (!$_COOKIE['username']){
    _alert_back('非法登陆');
}
//执行上传图片功能
if($_GET['action']=='up'){
if (!!$_rows=_fetch_array("SELECT 
                                   tg_uniqid                     
                                FROM 
                                   tg_user 
                                WHERE 
                                   tg_username='{$_COOKIE['username']}'LIMIT 1")) {
    _uniqid($_rows['tg_uniqid'], $_COOKIE['uniqid']);
//开始上传图片
    $_files=array('image/jpeg','image/pjpeg','image/png','image/x-png','image/gif');
if (is_array($_files)){
    if (!in_array($_FILES['userfile']['type'],$_files)){
        _alert_back('上传图片必须是jpg,png,gif中的一种');
    }
}
if ($_FILES['userfile']['error']>0){
    switch ($_FILES['userfile']['error']){
        case 1:
        _alert_back('上传文档超过约定值1');
        break;
        case 2:_alert_back('上传文档超过约定值2');
            break;
        case 3:_alert_back('部分文件被上传');
            break;
        case 4:_alert_back('没有文件被上传');
            break;
    }
    exit;
}
if ($_FILES['userfile']['size']>1000000){
    _alert_back('上传文件不能超过1M');
}
if (is_uploaded_file($_FILES['userfile']['tmp_name'])){
    if (!@move_uploaded_file($_FILES['userfile']['tmp_name'],'photo\1506482141/'.$_FILES['userfile']['name'])){
        _alert_back('移动失败');
    }else{
        _alert_close('上传成功');
    }
}

else{
_alert_back('上传临时文件不存在！');
}



}else{
    _alert_back('非法登陆');
}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" " http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns=" http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <?php
    require ROOT_PATH.'includes/title.inc.php';
    ?>
    <SCRIPT type="text/javascript" src="js/opener.js "></SCRIPT>
</head>
<body>

<div id="upimg" style="padding: 20px;">
    <form enctype="multipart/form-data" action="upimg.php?action=up" method="post">
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
        选择图片 ：<input type="file" name="userfile"/>
        <input type="submit"  value="上传"/>
    </form>
</div>
</body>
</html>

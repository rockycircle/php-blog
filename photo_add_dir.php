<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/17
 * Time: 13:34
 */
session_start();
define('IN_TG',true);

define('SCRIPT','photo_add_dir');
require dirname(__FILE__).'/includes/common.inc.php';
//这张页面必须是管理员才能登陆
_manage_login();


//添加目录
if ($_GET['action']=='addir') {

    if (!!$_rows = _fetch_array("SELECT 
                                   tg_uniqid         
                                FROM 
                                   tg_user 
                                WHERE 
                                   tg_username='{$_COOKIE['username']}'
                                   LIMIT 1")
    ) {
        _uniqid($_rows['tg_uniqid'], $_COOKIE['uniqid']);
include 'includes/check.func.php';



        //接受数据
        $_clean=array();
        $_clean['name']=_check_dir_name($_POST['name'],2,20);
        $_clean['type']=$_POST['type'];
        if (!empty($_clean['type'])){
            $_clean['password']=_check_dir_password($_POST['password'],6);
        }

        $_clean['content']=$_POST['content'];
        $_clean['dir']=time();
         $_clean=_mysql_string($_clean);
//先检查一下主目录是否存在
if (!is_dir('photo')){
    mkdir('photo',0777);
}
        //再在这个主目录里面创建你定义的主目录
        if(!is_dir('photo/'.$_clean['dir'])) {
            mkdir('photo/' . $_clean['dir']);
        }
//把当前信息写入数据库
if (empty($_clean['type'])){
    _query("INSERT INTO tg_dir
                      (tg_name,
                      tg_type,
                      tg_content,
                      tg_dir,
                      tg_date
                       
                       
                      )VALUES (
                      '{$_clean['name']}',
                      '{$_clean['type']}',
                      '{$_clean['content']}',
                      'photo/{$_clean['dir']}',
                      NOW()
                                         
                      )

");
}else{
    _query("INSERT INTO tg_dir
                      (tg_name,
                      tg_type,
                      tg_content,
                      tg_dir,
                      tg_date,
                       tg_password
                       
                      )VALUES (
                      '{$_clean['name']}',
                      '{$_clean['type']}',
                      '{$_clean['content']}',
                      'photo/{$_clean['dir']}',
                      NOW(),
                       '{$_clean['password']}'                  
                      )

");

}

//目录添加成功
        if (_affected_rows()==1) {
             _close();
//跳转
            _location('目录添加成功', 'photo.php');
        }else{
            _close();
//跳转
            _alert_back('目录添加失败！');

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
    <script type="text/javascript" src="js/photo_add_dir.js"></script>
</head>
<body>
<?php
require ROOT_PATH.'includes/header.inc.php';
?>

<div id="photo">
    <h2>添加相册目录</h2>
    <form method="post" action="?action=addir">
    <dl>
        <dd>相册名称：<input type="text"name="name"class="text"></dd>
        <dd>相册类型：<input type="radio"name="type"value="0"checked="checked"/>公开<input type="radio"name="type"value="1"/>私密</dd>
        <dd id="pass">相册密码：<input type="text"name="password"class="text"></dd>
        <dd>相册描述：<textarea name="content"></textarea></dd>
        <dd><input type="submit" value="添加目录" class="submit"/></dd>

    </dl>
    </form>
</div>

<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>

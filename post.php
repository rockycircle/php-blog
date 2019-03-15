<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/13
 * Time: 17:19
 */
session_start();
define('IN_TG',true);

define('SCRIPT','post');
require dirname(__FILE__).'/includes/common.inc.php';
if(!isset($_COOKIE['username'])){
    _location('发帖前必须登录','login.php');

}
if ($_GET['action']=='post'){
    _check_code($_POST['code'],$_SESSION['code']);
if (!!$_rows=_fetch_array("SELECT 
                                   tg_uniqid,
                                    tg_post_time
                                FROM 
                                   tg_user 
                                WHERE 
                                   tg_username='{$_COOKIE['username']}'LIMIT 1")) {

    global $_system;
    _uniqid($_rows['tg_uniqid'], $_COOKIE['uniqid']);
//发帖时间限制
    _timed(time(),$_rows['tg_post_time'],$_system['post']);

         include ROOT_PATH.'includes/check.func.php';
    //接受帖子内容

    $_clean=array();
    $_clean['username']=$_COOKIE['username'];
    $_clean['type']=$_POST['type'];
    $_clean['title']=_check_post_title($_POST['title'],2,40);
    $_clean['content']=_check_post_content($_POST['content'],10);
    $_clean['date']=$_POST['date'];
$_clean=_mysql_string($_clean);
_query("INSERT INTO tg_artical(
                            tg_username,
                            tg_title,
                            tg_type,
                            tg_content,
                            tg_date
                               )
                               VALUES(
                               '{$_clean['username']}',
                               '{$_clean['title']}',         
                               '{$_clean['type']}',
                               '{$_clean['content']}',
                               NOW()
                               )");
    if (_affected_rows()==1) {

        $_clean['id']=_insert_id();
        //setcookie('post_time',time());
      $_clean['time']=time();
       _query("UPDATE
                            tg_user
                            SET
                            tg_post_time='{$_clean['time']}'
                            WHERE
                            tg_username='{$_COOKIE['username']}'
                            ");

        _close();
//跳转
       // _session_destroy();

        _location('恭喜你，帖子发表成功', 'article.php?id='.$_clean['id']);
    }else{
        _close();
//跳转
       // _session_destroy();
        _alert_back('很遗憾，帖子发表失败！');

    }


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

    <script type="text/javascript" src="js/post.js "></script>
    <script type="text/javascript" src="js/code.js "></script>
</head>
<body>
<?php
require ROOT_PATH.'includes/header.inc.php';
?>
<div id="post">
    <h2>发表帖子<h2>
            <form method="post" name="post" action="?action=post">

                <dl>
                    <dt></dt>
                    <dt>请认真填写以下内容</dt>
                    <dd>
                        类  型：
                        <?php
                        foreach (range(1,16) as $_num){
                            if($_num==1) {
                                echo '<label for="type'.$_num.'"><input type="radio" id="type'.$_num.'" name="type" value="'.$_num.'"  checked="checked"/>';
                            }else{
                                echo '<label for="type'.$_num.'"><input type="radio" id="type'.$_num.'" name="type" value="'.$_num.'"/>';
                            }
                            echo '<img src="images/icon'.$_num.'.gif" alt="类型"/></label>';
                                     if($_num==8){
                                         echo '<br/>';
                                     }
                        }
                        ?>
                    </dd>
                    <dd>标题：<input type="text" name="title" class="text"/>(*2—40位)</dd>
                    <dd id="q">贴图：<a href="javascript:;">Q图系列【1】</a>   <a href="javascript:;">Q图系列【2】</a></dd>
                    <dd>
                        <?php  include ROOT_PATH.'includes/ubb.inc.php'?>
                        <textarea name="content" rows="9"></textarea></dd>
                    <dd>验证码 ：<input type="text" name="code" class="text yzm"/><img src="code.php" id="code" /><input type="submit" class="submit" value="发表" /></dd>
                </dl>
            </form>
</div>
<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>

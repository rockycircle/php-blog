<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/13
 * Time: 17:19
 */
session_start();
define('IN_TG',true);

define('SCRIPT','article_modify');
require dirname(__FILE__).'/includes/common.inc.php';
if(!isset($_COOKIE['username'])){
    _location('发帖前必须登录','login.php');

}
//修改
if ($_GET['action']=='modify'){
_check_code($_POST['code'],$_SESSION['code']);
if (!!$_rows=_fetch_array("SELECT 
                                   tg_uniqid 
                                FROM 
                                   tg_user 
                                WHERE 
                                   tg_username='{$_COOKIE['username']}'LIMIT 1")) {

    _uniqid($_rows['tg_uniqid'], $_COOKIE['uniqid']);
    include ROOT_PATH.'includes/check.func.php';
    $_clean=array();
    $_clean['id']=$_POST['id'];
    $_clean['type']=$_POST['type'];
    $_clean['title']=_check_post_title($_POST['title'],2,40);
    $_clean['content']=_check_post_content($_POST['content'],10);
    $_clean=_mysql_string($_clean);
    //执行sql
    _query("UPDATE tg_artical SET
                          tg_type='{$_clean['type']}',
                          tg_title='{$_clean['title']}',
                          tg_content='{$_clean['content']}',
                       tg_last_modify_date=NOW()
                     
                     WHERE
                     tg_id='{$_clean['id']}'
    ");
    if (_affected_rows()==1) {

        _close();
//跳转
        //_session_destroy();

        _location('恭喜你，帖子修改成功', 'article.php?id='.$_clean['id']);
    }else{
        _close();
//跳转
        //_session_destroy();
        _alert_back('很遗憾，帖子修改失败！');

    }

}else{
    _alert_back('非法登陆');
}
}

//读取数据
if(isset($_GET['id'])){
if(!!$_rows=_fetch_array("SELECT 
                           tg_username,
                           tg_title,
                            tg_type,
                            tg_content
                       
                           FROM 
                           tg_artical 
                           WHERE 
                           tg_reid=0
                           AND 
                           tg_id='{$_GET['id']}'")) {

    $_html=array();
    $_html['id']= $_GET['id'];
    $_html['username']=$_rows['tg_username'];
    $_html['title']=$_rows['tg_title'];
    $_html['type']=$_rows['tg_type'];
    $_html['content']=$_rows['tg_content'];
   $_html=_html($_html);

   //判断权限
    if($_COOKIE['username']!=$_html['username']){
        _alert_back('你没有权限');
    }

}else{
    _alert_back('不存在此帖子');
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

    <script type="text/javascript" src="js/post.js "></script>
    <script type="text/javascript" src="js/code.js "></script>
</head>
<body>
<?php
require ROOT_PATH.'includes/header.inc.php';
?>
<div id="post">
    <h2>修改帖子<h2>
            <form method="post" name="post" action="?action=modify">
<input type="hidden" value="<?php echo $_html['id']?>" name="id">
                <dl>
                    <dt></dt>
                    <dt>请认真修改以下内容</dt>
                    <dd>
                        类  型：
                        <?php
                        foreach (range(1,16) as $_num){
                            if($_num==$_html['type']) {
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
                    <dd>标题：<input type="text" name="title" value="<?php echo $_html['title']?>" class="text"/>(*2—40位)</dd>
                    <dd id="q">贴图：<a href="javascript:;">Q图系列【1】</a>   <a href="javascript:;">Q图系列【2】</a></dd>
                    <dd>
                        <?php  include ROOT_PATH.'includes/ubb.inc.php'?>
                        <textarea name="content" rows="9" ><?php echo $_html['content']?></textarea></dd>
                    <dd>验证码 ：<input type="text" name="code" class="text yzm"/><img src="code.php" id="code" /><input type="submit" class="submit" value="修改帖子" /></dd>
                </dl>
            </form>
</div>
<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>

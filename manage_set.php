<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/18
 * Time: 16:22
 */
session_start();
define('IN_TG',true);

define('SCRIPT','manage_set');
require dirname(__FILE__).'/includes/common.inc.php';
//是否正常登陆
_manage_login();
//修改系统表
if($_GET['action']=='set') {
    if (!!$_rows = _fetch_array("SELECT 
                                   tg_uniqid 
                                FROM 
                                   tg_user 
                                WHERE 
                                   tg_username='{$_COOKIE['username']}'LIMIT 1")
    ) {

        _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
$_clean=array();
$_clean['webname']=$_POST['webname'];
$_clean['article']=$_POST['article'];
        $_clean['blog']=$_POST['blog'];
        $_clean['photo']=$_POST['photo'];
        $_clean['skin']=$_POST['skin'];
        $_clean['post']=$_POST['post'];
        $_clean['re']=$_POST['re'];
        $_clean['code']=$_POST['code'];
        $_clean['register']=$_POST['register'];
        $_clean['string']=$_POST['string'];
$_clean=_mysql_string($_clean);
_query("UPDATE tg_system SET 
                           tg_webname='{$_clean['webname']}',
                           tg_article='{$_clean['article']}',
                          tg_blog='{$_clean['blog']}',
                         tg_photo='{$_clean['photo']}',        
                          tg_skin='{$_clean['skin']}',  
                          tg_post='{$_clean['post']}',  
                          tg_re='{$_clean['re']}',  
                          tg_code='{$_clean['code']}',  
                           tg_register='{$_clean['register']}',
                         tg_string='{$_clean['string']}'
                           WHERE
                           tg_id=1
                           LIMIT
                           1


");
        if (_affected_rows()==1) {
            _close();
//跳转
            _location('恭喜你，修改成功', 'manage_set.php');
        }else{
            _close();
//跳转
            _location('很遗憾，没有被修改', 'manage_set.php');

        }


    }else{
        _alert_back('异常');
    }
}
//读取表
if(!! $_rows=_fetch_array("SELECT 
                  tg_webname,
                  tg_article,
                  tg_blog,
                  tg_photo,
                  tg_skin,
                  tg_string,
                  tg_post,
                  tg_re,
                  tg_code,
                  tg_register
                FROM 
                   tg_system
                WHERE 
                   tg_id=1
                LIMIT 1
                "))
{
$_html=array();
$_html['webname']=$_rows['tg_webname'];
    $_html['article']=$_rows['tg_article'];
    $_html['blog']=$_rows['tg_blog'];
    $_html['photo']=$_rows['tg_photo'];
    $_html['skin']=$_rows['tg_skin'];
    $_html['string']=$_rows['tg_string'];
    $_html['post']=$_rows['tg_post'];
    $_html['re']=$_rows['tg_re'];
    $_html['code']=$_rows['tg_code'];
    $_html['register']=$_rows['tg_register'];

    $_html=_html($_html);

if($_html['article']==10){
    $_html['article_html']='<select name="article"><option value="10" selected="selected">每页10篇</option><option value="15" >每页15篇</option></select>';
}elseif($_html['article']==15){
    $_html['article_html']='<select name="article"><option value="10" >每页10篇</option><option value="15" selected="selected">每页15篇</option></select>';
}

    if($_html['blog']==15){
        $_html['blog_html']='<select name="blog"><option value="15" selected="selected">每页15人</option><option value="20" >每页20人</option></select>';
    }elseif($_html['blog']==20){
        $_html['blog_html']='<select name="blog"><option value="15" >每页15人</option><option value="20" selected="selected">每页20人</option></select>';
    }

    if($_html['photo']==8){
        $_html['photo_html']='<select name="photo"><option value="8" selected="selected">每页8张</option><option value="12" >每页12张</option></select>';
    }elseif($_html['photo']==12){
        $_html['photo_html']='<select name="photo"><option value="8" >每页8张</option><option value="12" selected="selected">每页12张</option></select>';
    }
    if($_html['skin']==1){
        $_html['skin_html']='<select name="skin"><option value="1" selected="selected">一号皮肤</option><option value="2" >二号皮肤</option><option value="3" >三号皮肤</option></select>';
    }elseif($_html['skin']==2){
        $_html['skin_html']='<select name="skin"><option value="2" >二号皮肤</option><option value="2" selected="selected">三号皮肤</option><option value="3" >三号皮肤</option></select>';
    }elseif($_html['skin']==3){
        $_html['skin_html']='<select name="skin"><option value="2" >二号皮肤</option><option value="2" >三号皮肤</option><option value="3" selected="selected">三号皮肤</option></select>';
    }

    if($_html['post']==30){
        $_html['post_html']='<input type="radio" name="post" value="30" checked="checked"/>30秒<input type="radio" name="post" value="60"/>一分钟<input type="radio" name="post" value="180"/>3分钟';
    }elseif($_html['post']==60){
        $_html['post_html']='<input type="radio" name="post" value="30"/>30秒<input type="radio" name="post" value="60" checked="checked"/>一分钟<input type="radio" name="post" value="180"/>3分钟';
    }elseif($_html['post']==180){
        $_html['post_html']='<input type="radio" name="post" value="30"/>30秒<input type="radio" name="post" value="60" "/>一分钟<input type="radio" name="post" value="180" checked="checked"/>3分钟';
    }
    if($_html['re']==15){
        $_html['re_html']='<input type="radio" name="re" value="15" checked="checked"/>30秒<input type="radio" name="re" value="30"/>一分钟<input type="radio" name="re" value="45"/>3分钟';
    }elseif($_html['re']==20){
        $_html['re_html']='<input type="radio" name="re" value="30"/>30秒<input type="radio" name="re" value="30" checked="checked"/>一分钟<input type="radio" name="re" value="45"/>3分钟';
    }elseif($_html['re']==45){
        $_html['re_html']='<input type="radio" name="re" value="30"/>30秒<input type="radio" name="re" value="45" "/>一分钟<input type="radio" name="re" value="45" checked="checked"/>3分钟';
    }

    if($_html['code']==1){
        $_html['code_html']='<select name="code"><option value="1" selected="selected">启用</option><option value="0" >禁用</option></select>';
    }elseif($_html['code']==0){
        $_html['code_html']='<select name="code"><option value="8" >启用</option><option value="12" selected="selected">禁用</option></select>';
    }
    if($_html['register']==1){
        $_html['register_html']='<select name="register"><option value="1" selected="selected">启用</option><option value="0" >禁用</option></select>';
    }elseif($_html['register']==0){
        $_html['register_html']='<select name="register"><option value="8" >启用</option><option value="12" selected="selected">禁用</option></select>';
    }



}else{
    _alert_back('系统表读取错误，请联系管理员！');
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
<?php require ROOT_PATH.'includes/manage.inc.php';?>
    <div id="member_main">
        <h2>后台管理中心</h2>
        <form method="post" action="?action=set">
        <dl>
            <dd>网站名称：<input type="text" class="text" name="webname" value="<?php echo $_html['webname'] ?>"></dd>
            <dd>文章每页列表数：<?php echo $_html['article_html']?></dd>
            <dd>博客每页列表数：<?php echo $_html['blog_html']?></dd>
            <dd>相册每页列表数：<?php echo $_html['photo_html']?></dd>
            <dd>站点 默认 皮肤：<?php echo $_html['skin_html']?></dd>
            <dd>非法 字符 过滤：<input type="text" class="text" name="string" value="<?php echo $_html['string'] ?>"></dd>
            <dd>每次发帖限制：<?php echo $_html['post_html'] ?></dd>
            <dd>每次回帖限制：<?php echo $_html['re_html'] ?></dd>
            <dd>是否启用验证码：<?php echo $_html['code_html'] ?></dd>
            <dd>是否开放注册：<?php echo $_html['register_html'] ?></dd>
            <dd><input type="submit" value="修改系统设置" class="submit"></dd>

        </dl>
    </div>
</div>
<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>


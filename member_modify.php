<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/18
 * Time: 16:22
 */
session_start();
define('IN_TG',true);

define('SCRIPT','member_modify');
require dirname(__FILE__).'/includes/common.inc.php';
//是否正常登陆
if ($_GET['action']=='modify'){
    _check_code($_POST['code'],$_SESSION['code']);
   if (!!$_rows=_fetch_array("SELECT 
                                   tg_uniqid 
                                FROM 
                                   tg_user 
                                WHERE 
                                   tg_username='{$_COOKIE['username']}'LIMIT 1")) {

_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
       include ROOT_PATH . 'includes/check.func.php';
       $_clean = array();
       $_clean['password'] = _check_modify_password($_POST['password'], 6);
       $_clean['sex'] = _check_sex($_POST['sex']);
       $_clean['switch'] = _check_sex($_POST['switch']);
       $_clean['face'] = _check_face($_POST['face']);
       $_clean['email'] = _check_email($_POST['email'], 6, 40);
       $_clean['qq'] = _check_qq($_POST['qq']);
       $_clean['url'] = _check_url($_POST['url'], 40);
       $_clean['antograph'] = _check_antograph($_POST['autograph'],200);
       print_r($_clean);


       if (empty($_clean['password'])) {
           _query(" UPDATE tg_user SET
                             
                             tg_sex='{$_clean['sex']}',
                             tg_switch='{$_clean['switch']}',
                             tg_antograph='{$_clean['antograph']}',
                             tg_face='{$_clean['face']}',
                             tg_email='{$_clean['email']}',
                             tg_qq='{$_clean['qq']}',
                             tg_url='{$_clean['url']}'
                   WHERE 
                             
                             tg_username='{$_COOKIE['username']}'
                                      
        ");
       } else {
           _query("UPDATE tg_user SET
                             tg_password='{$_clean['password']}',
                             tg_sex='{$_clean['sex']}',
                             tg_switch='{$_clean['switch']}',
                             tg_antograph='{$_clean['antograph']}',
                             tg_face='{$_clean['face']}',
                             tg_email='{$_clean['email']}',
                             tg_qq='{$_clean['qq']}',
                             tg_url='{$_clean['url']}'
                   WHERE
                              tg_username='{$_COOKIE['username']}'
        ");
       }
   }
    //判断修改
    if (_affected_rows()==1) {
        _close();
//跳转
       // _session_destroy();
        _location('恭喜你，修改成功', 'member.php');
    }else{
        _close();
//跳转
      //  _session_destroy();
        _location('很遗憾，没有被修改', 'member_modify.php');

    }

}



if(isset($_COOKIE['username'])){
   //获取数据
    $_rows=_fetch_array("SELECT 
                              tg_switch,
                              tg_antograph,
                              tg_username,
                              tg_sex,
                              tg_face,
                              tg_email,
                              tg_url,
                              tg_qq 
                           FROM 
                              tg_user 
                           WHERE  
                               tg_username='{$_COOKIE['username']}'");
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
    $_html['switch']=$_rows['tg_switch'];
    $_html['antograph']=$_rows['tg_antograph'];
    $_html=_html($_html);
    print_r($_html);
if($_html['sex']=='男'){
    $_html['sex_html']='<input type="radio" value="男" name="sex" checked="checked"/>男<input type="radio" value="女" name="sex" "/>女';
}elseif($_html['sex']=='女'){
    $_html['sex_html']='<input type="radio" value="女" name="sex" checked="checked"/>女<input type="radio" value="男" name="sex" "/>男';
}
$_html['face_html']='<select name="face">';
foreach (range(1,11)as $_num){
   $_html['face_html'].='<option value="face/'.$_num.'.jpg">face/'.$_num.'.jpg</option>';
}
$_html['face_html'].='</select>';

    //签名开关

    if($_html['switch']==1){
        $_html['switch_html']='<input type="radio" name="switch" value="1" checked="checked"/>启用<input type="radio" name="switch" value="0"/>禁用
';
    }elseif ($_html['switch']==0) {
        $_html['switch_html'] = '<input type="radio" name="switch" value="1" />启用<input type="radio" name="switch" checked="checked" value="0"/>禁用
';
}else{

        _alert_back('此用户不存在');




}
}else{
    echo '非法登陆';
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
    <script type="text/javascript" src="js/code.js"></script>
    <script type="text/javascript" src="js/member_modify.js"></script>
</head>
<body>
<?php
require ROOT_PATH.'includes/header.inc.php';
?>
<div id="member">
<?php require ROOT_PATH.'includes/member.inc.php';?>
    <div id="member_main">
        <h2>会员管理中心</h2>
        <form name="modify " method="post" action="member_modify.php?action=modify">
        <dl>
            <dd>性   别：<?php echo $_html['username']?></dd>
            <dd>密   码：<input type="password" class="text" name="password" />留空则不修改</dd>
            <dd>性   别：<?php echo $_html['sex_html']?></dd>
            <dd>头   像：<?php echo $_html['face_html']?></dd>
            <dd>电子邮件：<input type="text" class="text" name="email" value="<?php echo $_html['email']?>"/></dd>
            <dd>主   页：<input type="text" class="text" name="url" value="<?php echo $_html['url']?>"/></dd>
            <dd>Q    Q：<input type="text" class="text" name="qq" value="<?php echo $_html['qq']?>"/></dd>
            <dd>个性签名  <?php echo $_html['switch_html']?>(可用ubb)
                <p> <textarea name="autograph"><?php echo $_html['antograph']?></textarea></p>
            </dd>
            <dd>验证码 ：<input type="text" name="code" class="text yzm"/><img src="code.php" id="code" /><input type="submit" class="submit" value="修改资料" /></dd>
<!--            <dd><input type="submit" class="submit" value="修改资料" /></dd>-->
        </dl>
        </form>
    </div>
</div>
<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>


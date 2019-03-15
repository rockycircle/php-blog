<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/13
 * Time: 17:19
 */
session_start();

define('IN_TG',true);

define('SCRIPT','register');
require dirname(__FILE__).'/includes/common.inc.php';

_login_state();
//判断是否提交了
global  $_system;
if($_GET['action']=='register')
{
//为了防止恶意注册，和跨站攻
if (empty($_system['register'])){
    exit('不要非法注册');
}
_check_code($_POST['code'],$_SESSION['code']);

//引入验证文件
    include ROOT_PATH.'includes/check.func.php';

  $_clean=array();


    $_clean['uniqid']= _check_uniqid($_POST['uniqid'],$_SESSION['uniqid']);
    $_clean['active']=_sha1_uniqid();
    $_clean['username']=_check_username($_POST['username'],2,20);
    $_clean['password']=_check_password($_POST['password'],$_POST['notpassword'],4);
    $_clean['question']=_check_question($_POST['question'],2,20);
    $_clean['answer']=_check_answer($_POST['question'],$_POST['answer'],2,20);
    $_clean['sex']=_check_sex($_POST['sex']);
    $_clean['face']=_check_face($_POST['face']);
    $_clean['email']=_check_email($_POST['email'],6,40);
    $_clean['qq']=_check_qq($_POST['qq']);
    $_clean['url']=_check_url($_POST['url'],40);

    //判断用户名是否重复


//    if(_fetch_array("SELECT tg_username FROM tg_user WHERE tg_username='{$_clean['username']}'")){
//        _alert_back('对不起，此用户已被注册');
//    }

    _is_repeat(
        "SELECT tg_username FROM tg_user WHERE tg_username='{$_clean['username']}'LIMIT 1",
        '对不起，此用户已被注册'
    );


    //测试新增
       _query("INSERT INTO tg_user(

                                        tg_uniqid,
                                        tg_active,
                                        tg_username,
                                        tg_password,
                                        tg_question,
                                        tg_answer,
                                        tg_sex,
                                        tg_face,
                                        tg_email,
                                        tg_qq,
                                        tg_url,
                                        tg_reg_time,
                                        tg_last_time,
                                        tg_last_ip


)VALUES(


                              '{$_clean['uniqid']}',
                              '{$_clean['active']}',
                              '{$_clean['username']}',
                              '{$_clean['password']}',
                              '{$_clean['question']}',
                              '{$_clean['answer']}',
                              '{$_clean['sex']}',
                              '{$_clean['face']}',
                              '{$_clean['email']}',
                              '{$_clean['qq']}',
                              '{$_clean['url']}',
                              NOW(),
                              NOW(),
                              '{$_SERVER["REMOTE_ADDR"]}'
)"
    );
       if (_affected_rows()==1) {

           $_clean['id']=_insert_id();
           _close();
//跳转
         //  _session_destroy();
_set_xml('new.xml',$_clean);

           _location('恭喜你，注册成功', 'active.php?active='.$_clean['active']);
       }else{
           _close();
//跳转
          // _session_destroy();
           _location('很遗憾，注册失败', 'register.php');

       }

}else {
    $_SESSION['uniqid'] = $_uniqid = _sha1_uniqid($_POST['uniqid']);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" " http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns=" http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <?php
    require ROOT_PATH.'includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/register.js "></script>
    <script type="text/javascript" src="js/code.js "></script>
</head>
<body>
<?php
require ROOT_PATH.'includes/header.inc.php';
?>
<div id="register">
    <h2>会员注册<h2>
            <?php if (!empty($_system)){?>
            <form method="post" name="register" action="register.php?action=register">
              <input type="hidden" name="uniqid" value="<?php echo $_uniqid?>">
                <dl>
                    <dt></dt>
                    <dt>请认真填写以下内容</dt>
                    <dd>用户名：<input type="text" name="username" class="text"/>(*必填至少两位)</dd>
                    <dd>密  码：<input type="password" name="password" class="text"/>(*必填至少六位)</dd>
                    <dd>确认密码：<input type="password" name="notpassword" class="text"/>(*必填  同上)  </dd>
                    <dd>密码提示：<input type="text" name="question" class="text"/>(*必填至少两位)</dd>
                    <dd>密码回答：<input type="text" name="answer" class="text"/>(*必填至少两位)</dd>
                    <dd>性  别：<input type="radio" name="sex" value="男"checked="checked"/>男<input type="radio" name="sex" value="女"/>女</dd>
                    <dd><input type="hidden" name="face" value="face/11.jpg" ><img src="face/11.jpg"alt="头像选择" id="faceimg"/></dd>
                    <dd>电子邮件：<input type="text" name="email" class="text"/>(*必填，用于激活)</dd>
                    <dd> Q Q ：<input type="text" name="qq" class="text"/></dd>
                    <dd>主页地址：<input type="text" name="url" class="text" value="http://"/></dd>
                    <dd>验证码 ：<input type="text" name="code" class="text yzm"/><img src="code.php" id="code" /></dd>
                    <dd><input type="submit" class="submit" value="注册" /></dd>
                </dl>
            </form>
            <?php }else{
                echo '<h4>本站关闭了注册</h4>';
            }?>
</div>
<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>

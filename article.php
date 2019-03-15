<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/17
 * Time: 13:34
 */
session_start();
define('IN_TG',true);

define('SCRIPT','article');
require dirname(__FILE__).'/includes/common.inc.php';
//接受处理回帖
if($_GET['action']=='rearticle'){

        _check_code($_POST['code'], $_SESSION['code']);

if (!!$_rows=_fetch_array("SELECT 
                                   tg_uniqid,
                                    tg_article_time
                                FROM 
                                   tg_user 
                                WHERE 
                                   tg_username='{$_COOKIE['username']}'LIMIT 1")) {
global $_system;
    _uniqid($_rows['tg_uniqid'], $_COOKIE['uniqid']);
    _timed(time(),$_rows['tg_article_time'],$_system['re']);

    $_clean= array();
    $_clean['reid']= $_POST['reid'];
    $_clean['type']= $_POST['type'];
    $_clean['title']= $_POST['title'];
    $_clean['content']= $_POST['content'];
    $_clean['username']= $_COOKIE['username'];
    $_clean=_mysql_string($_clean);

_query("INSERT INTO tg_artical(
                                   tg_reid,
                                   tg_username,
                                   tg_title,
                                   tg_type,
                                   tg_content,
                                   tg_date
                                   )
                                   VALUES
                                   (
                                   '{$_clean['reid']}',
                                   '{$_clean['username']}',
                                   '{$_clean['title']}',
                                   '{$_clean['type']}',
                                   '{$_clean['content']}',
                                   NOW()
                                   
                                   )"
);
 if (_affected_rows()==1) {
    // setcookie('article_time',time());
     $_clean['time']=time();
     _query("UPDATE
                            tg_user
                            SET
                            tg_article_time='{$_clean['time']}'
                            WHERE
                            tg_username='{$_COOKIE['username']}'
                            ");

     _query("UPDATE tg_artical SET tg_commendcount=tg_commendcount+1 WHERE tg_reid=0 AND tg_id='{$_clean['reid']}'");
     _close();
//跳转
     //_session_destroy();

     _location('恭喜你，回帖发表成功', 'article.php?id='.$_clean['reid']);
 }else{
     _close();
//跳转
     //_session_destroy();
     _alert_back('很遗憾，回帖发表失败！');

 }
}else{
    _alert_back('非法登陆');
}
}


//读出数据
if (isset($_GET['id'])){
    if(!!$_rows=_fetch_array("SELECT 
                           tg_id,
                           tg_username,
                           tg_title,
                            tg_type,
                            tg_content,
                            tg_readcount,
                            tg_commendcount,
                            tg_last_modify_date,
                            tg_date
                            
                           FROM 
                           tg_artical 
                           WHERE tg_id='{$_GET['id']}'")){

        _query("UPDATE tg_artical
                           SET 
                           tg_readcount=tg_readcount+1 
                           WHERE 
                           tg_reid=0
                           AND 
                           tg_id='{$_GET['id']}'");


        $_html=array();
        $_html['reid']= $_rows['tg_id'];
       $_html['username_subject']=$_rows['tg_username'];
        $_html['title']=$_rows['tg_title'];
        $_html['type']=$_rows['tg_type'];
        $_html['content']=$_rows['tg_content'];
        $_html['readcount']=$_rows['tg_readcount'];
        $_html['commendcount']=$_rows['tg_commendcount'];
        $_html['last_modify_date']=$_rows['tg_last_modify_date'];
        $_html['date']=$_rows['tg_date'];



        if (!!$_rows= _fetch_array("SELECT 
                                      tg_id,
                                      tg_sex,
                                      tg_face,
                                      tg_email,
                                      tg_url ,
                                      tg_switch,
                                      tg_antograph
                                      From  
                                      tg_user 
                                      WHERE 
                                      tg_username='{$_html['username_subject']}'")){

            $_html['userid']=$_rows['tg_id'];
            $_html['sex']=$_rows['tg_sex'];
            $_html['face']=$_rows['tg_face'];
            $_html['email']=$_rows['tg_email'];
            $_html['url']=$_rows['tg_url'];
            $_html['switch']=$_rows['tg_switch'];
            $_html['antograph']=$_rows['tg_antograph'];
            $_html=_html($_html);
//创建全局变量做一个带参数的分页
        global $_id;
        $_id='id='.$_html['reid'].'&';
//主题帖子修改
       $_html['subject_modify']=null;
if($_html['username_subject']==$_COOKIE['username']){
    $_html['subject_modify']='[<a href="article_modify.php?id='.$_html['reid'].'">修改</a>]';
}

        $_html['last_modify_date_string']=null;
if($_html['last_modify_date']!='0000-00-00 00:00:00'){
    $_html['last_modify_date_string']='本帖已由['.$_html['username_subject'].']于'.$_html['last_modify_date'].'修改过!';
}

if ($_COOKIE['username']){
    $_html['re']='<span><a href="#ree" name="re" title="回复1楼的'.$_html['username_subject'].'">[回复]</a></span>';
}
//个性签名
        if($_html['switch']==1){
$_html['antograph_html']='<p class="antograph">'.$_html['antograph'].'</p>';
        }



            //读取回帖
            global $_pagenum,$_pagesize,$_page;
            _page("SELECT tg_id FROM tg_artical WHERE tg_reid='{$_html['reid']}'",10);
            $_result=_query("SELECT 
                         tg_username,
                         tg_type,
                         tg_title,
                         tg_content,
                         tg_date
                      FROM 
                         tg_artical 
                         WHERE
                         tg_reid='{$_html['reid']}'
                      ORDER BY 
                         tg_date 
                         ASC 
                         LIMIT $_pagenum,$_pagesize");





        }else{
            //用户已被删除
        }

    }else{
        _alert_back('不存在这个主题');
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
    <script type="text/javascript" src="js/article.js"></script>
    <script type="text/javascript" src="js/code.js"></script>
</head>
<body>
<?php
require ROOT_PATH.'includes/header.inc.php';
?>

<div id="article">
    <h2>帖子详情</h2>

    <?php
    if($_page==1){

    ?>
    <div id="subject">
<dl>
    <dd class="user"><?php echo $_html['username_subject']?>(<?php echo $_html['sex']?>)</dd>
    <dt><img src="<?php echo $_html['face']?>" alt="<?php echo $_html['username_subject'] ?>"/></dt>
    <dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html["userid"]?>">发消息</a></dd>
    <dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html["userid"]?>">加为好友</a></dd>
    <dd class="guest">写留言</dd>
    <dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html["userid"]?>">给她送花</a></dd>
    <dd class="email">邮件：<a href="mailto:<?php echo $_html['email'] ?>"><?php echo $_html['email'] ?></a></dd>
    <dd class="url">网址：<a href="mailto:<?php echo $_html['url'] ?>" target="_blank"><?php echo $_html['url'] ?></a></dd>
</dl>
        <div class="content">
            <div class="user">
                <span><?php echo $_html['subject_modify']?> 1#</span><?php echo $_html['username_subject']?>|发表于：<?php echo $_html['date']?>
            </div>
            <h3> 主题：<?php echo $_html['title']?>   <img src="" alt="icon"/><?php echo $_html['re']?></h3>
            <div class="detail" ">
                <?php echo _ubb($_html['content'])?>
                 <?php echo $_html['antograph_html'] ?>
            </div>
            <div class="read">
                <p> <?php  echo  $_html['last_modify_date_string'] ?></p>
                阅读量：（<?php echo $_html['readcount']?>）评论量（<?php echo $_html['commendcount']?>）
            </div>
        </div>
    </div>

<?php } ?>

    <p class="line"></p>

    <?php
    $_i=2;
    while(!!$_rows=_fetch_array_list($_result)){
    $_html['username']=$_rows['tg_username'];
        $_html['type']=$_rows['tg_type'];
        $_html['retitle']=$_rows['tg_title'];
        $_html['content']=$_rows['tg_content'];
        $_html['date']=$_rows['tg_date'];
        $_html=_html($_html);



    if (!!$_rows= _fetch_array("SELECT 
                                      tg_id,
                                      tg_sex,
                                      tg_face,
                                      tg_email,
                                      tg_url ,
                                      tg_switch,
                                      tg_antograph
                                      From  
                                      tg_user 
                                      WHERE 
                                      tg_username='{$_html['username']}'")) {

        $_html['userid'] = $_rows['tg_id'];
        $_html['sex'] = $_rows['tg_sex'];
        $_html['face'] = $_rows['tg_face'];
        $_html['email'] = $_rows['tg_email'];
        $_html['url'] = $_rows['tg_url'];
        $_html['switch'] = $_rows['tg_switch'];
        $_html['antograph'] = $_rows['tg_antograph'];

        $_html = _html($_html);
//楼层
        if($_page==1&&$_i==2) {

            if ($_html['username'] == $_html['username_subject']) {
                $_html['username_html'] = $_html['username'] . '(楼主)';
            } else {
                $_html['username_html'] = $_html['username'] . '(沙发)';
            }
        }else {

            $_html['username_html'] = $_html['username'];
        }


    }else{
        //这个用户可能已被删除

    }
    //跟贴回复
    if ($_COOKIE['username']){
    $_html['re'] =   '<span><a href="#ree" name="re" title="回复'.( $_i+(($_page-1)*$_pagesize)).'楼的'. $_html['username'] .'">[回复]</a></span>';
    }



        ?>

    <div class="re">
        <dl>
            <dd class="user"><?php echo  $_html['username_html']?>(<?php echo $_html['sex']?>)</dd>
            <dt><img src="<?php echo $_html['face']?>" alt="<?php echo $_html['username'] ?>"/></dt>
            <dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html["userid"]?>">发消息</a></dd>
            <dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html["userid"]?>">加为好友</a></dd>
            <dd class="guest">写留言</dd>
            <dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html["userid"]?>">给她送花</a></dd>
            <dd class="email">邮件：<a href="mailto:<?php echo $_html['email'] ?>"><?php echo $_html['email'] ?></a></dd>
            <dd class="url">网址：<a href="mailto:<?php echo $_html['url'] ?>" target="_blank"><?php echo $_html['url'] ?></a></dd>
        </dl>

        <div class="content">
            <div class="user" id="cuser">
                <span><?php echo $_i+(($_page-1)*$_pagesize); ?>#</span><?php echo $_html['username']?>|发表于：<?php echo $_html['date']?>
            </div>
            <h3> 主题：<?php echo $_html['retitle']?>   <img src="" alt="icon"/><?php echo  $_html['re'] ?></h3>
            <div class="detail">
           <?php  echo _ubb($_html['content'])?>
<?php
           //个性签名
           if($_html['switch']==1){
               echo  '.<p class="antograph">'._ubb($_html['antograph']).'</p>';
           }



         ?>
            </div>
            </div>
    </div>


    <p class="line"></p>
    <?php
    $_i++;
    }
    _free_result($_result);
    _paging(1);

    ?>

    <?php if(isset($_COOKIE['username'])){ ?>

    <form method="post" action="?action=rearticle">
        <input type="hidden" name="reid" value="<?php echo $_html['reid'] ?>"/>
        <input type="hidden" name="type" value="<?php echo $_html['type'] ?>"/>
        <dl>
            <dd>标题：<input type="text" name="title" class="text"value="RE:<?php echo $_html['title'] ?>"/>(*2—40位)</dd>
            <dd id="q">贴图：<a href="javascript:;">Q图系列【1】</a>   <a href="javascript:;">Q图系列【2】</a></dd>
            <dd>
                <?php  include ROOT_PATH.'includes/ubb.inc.php'?>
                <textarea name="content" rows="9"></textarea></dd>
            <dd>验证码 ：<input type="text" name="code" class="text yzm"/><img src="code.php" id="code" /><input type="submit" class="submit" value="发表" /></dd>

        </dl>
    </form>
    <?php
    }

    ?>
</div>

<a name="ree"></a>

<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>

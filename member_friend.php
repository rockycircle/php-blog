<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/19
 * Time: 19:46
 */
session_start();
define('IN_TG',true);

define('SCRIPT','member_friend');
require dirname(__FILE__).'/includes/common.inc.php';
if(!isset($_COOKIE['username'])){
    _alert_back('请先登录');
}

if ($_GET['action']=='check'&&isset($_GET['id']))
{
if (!!$_rows2=_fetch_array("SELECT
                                   tg_uniqid
                                FROM
                                   tg_user
                                WHERE
                                   tg_username='{$_COOKIE['username']}'LIMIT 1")){


_query("UPDATE 
              tg_friend 
              SET 
              tg_state=1 
              WHERE  
              tg_id='{$_GET['id']}'");
    if (_affected_rows()==1) {
        _close();
        _location('恭喜你，好友验证成功', 'member_friend.php');
    }else{
        _close();
        _alert_back('好友验证失败');
    }

}else{
_alert_back('非法登陆');
}

}

if($_GET['action']=='delete'&& isset($_POST['ids'])){
   $_clean=array();
    $_clean['ids']=_mysql_string(implode(',',$_POST['ids']));
if (!!$_rows2=_fetch_array("SELECT
                                   tg_uniqid
                                FROM
                                   tg_user
                                WHERE
                                   tg_username='{$_COOKIE['username']}'LIMIT 1")) {


    _uniqid($_rows2['tg_uniqid'], $_COOKIE['uniqid']);
    _query("DELETE
                      FROM
                         tg_friend
                      WHERE
                         tg_id
                      IN({$_clean['ids']})
                      ");
    if (_affected_rows()) {
        _close();
//跳转
        _location('恭喜你，好友删除成功', 'member_friend.php');
    }else{
        _close();
//跳转
        _alert_back('好友删除失败');

    }
}else{
    _alert_back('非法登陆');
}
}

global $_pagenum,$_pagesize;
_page("SELECT 
                   tg_id 
                FROM 
                   tg_friend  
                WHERE 
                   tg_touser='{$_COOKIE['username']}' OR tg_touser='{$_COOKIE['username']}'",10);

$_result=_query("SELECT 
                         tg_id,
                         tg_state,
                         tg_touser,
                         tg_fromuser,
                         tg_content,
                         tg_date 
                      FROM 
                         tg_friend 
                      WHERE 
                        tg_touser='{$_COOKIE['username']}'
                        OR 
                        tg_fromuser='{$_COOKIE['username']}'
                      ORDER BY 
                         tg_date 
                      DESC 
                         LIMIT $_pagenum,$_pagesize");





?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" " http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns=" http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <?php
    require ROOT_PATH.'includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/member_message.js"></script>
   </head>
<body>
<?php
require ROOT_PATH.'includes/header.inc.php';
?>
<div id="member">
    <?php require ROOT_PATH.'includes/member.inc.php';?>
    <div id="member_main">
        <h2>好友中心</h2>
        <form method="post" action="?action=delete">
        <table cellspacing="1">
            <tr><th>好友</th><th>请求内容</th><th>时间</th><th>状态</th><th>操作</th></tr>
      <?php
      $_html =array();
      while(!!$_rows=_fetch_array_list($_result)){

          $_html['id']=$_rows['tg_id'];
//          if (empty($_html['state']=$_rows['tg_state'])){
//              $_html['state']='<img src="img/wd.png" alt="未读" title="未读">';
//          }else{
//              $_html['state']='<img src="img/yd.png" alt="已读" title="已读">';
//          }
//
          $_html['touser']=$_rows['tg_touser'];
          $_html['fromuser']=$_rows['tg_fromuser'];
          $_html['content']=$_rows['tg_content'];
          $_html['date']=$_rows['tg_date'];
          $_html['state']=$_rows['tg_state'];
          $_html=_html($_html);
          if( $_html['touser']==$_COOKIE['username']){
              $_html['friend']=$_html['fromuser'];
              if (empty($_html['state'])){
                  $_html['state_html']='<a  href="?action=check&id='.$_html['id'].'" style="color: red">你未验证</a>';
              }else{
                  $_html['state_html']='<span style="color:green;">通过</span>';
              }
          }else if ($_html['fromuser']==$_COOKIE['username']){
              $_html['friend']=$_html['touser'];
              if (empty($_html['state'])){
                  $_html['state_html']='<span style="color: blue;">对方未验证</span>';
              }else{
                  $_html['state_html']='<span style="color:green;">通过</span>';
              }
          }


//          if (empty($_html['state']=$_rows['tg_state'])){
//              $_html['state']='<img src="images/wd.png" alt="未读" title="未读">';
//              $_html['content_html']='<strong>'._title($_html['content']).'</strong>';
//
//          }else{
//              $_html['state']='<img src="images/yd.png" alt="已读" title="已读">';
//              $_html['content_html']=_title($_html['content']);
//          }

          ?>
          <tr><td><?php echo  $_html['friend']?></td title="<?php  echo $_html['content'] ?>"><td><?php echo _title($_html['content'],14)?></td><td><?php echo  $_html['date']?></td><td><?php echo $_html['state_html']?></td><td><input name="ids[]" value="<?php echo $_html['id']?>" type="checkbox"/></td></tr>

       <?php
      }
      _free_result($_result);
      ?>

            <tr><td clospan="5"><label for="all">全选<input type="checkbox" name="chkall" id="all"/></label><input type="submit" value="批删除"/></td></tr>
        </table>   </form>
        <?php
        _paging(1);
        ?>

    </div>
<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>

<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/19
 * Time: 20:45
 */
session_start();
define('IN_TG',true);

define('SCRIPT','member_message_detail');
require dirname(__FILE__).'/includes/common.inc.php';
if(!isset($_COOKIE['username'])){
    _alert_back('请先登录');
}

if($_GET['action']=='delete'&&isset($_GET['id'])){
    if (!!$_rows=_fetch_array("SELECT 
                   tg_id
                FROM 
                   tg_message
                WHERE 
                   tg_id='{$_GET['id']}'
                LIMIT 1
                ")){

        if (!!$_rows2=_fetch_array("SELECT 
                                   tg_uniqid 
                                FROM 
                                   tg_user 
                                WHERE 
                                   tg_username='{$_COOKIE['username']}'LIMIT 1")) {


            _uniqid($_rows2['tg_uniqid'],$_COOKIE['uniqid']);
            //删除单短信
            _query("DELETE FROM 
                             tg_message 
                          WHERE 
                             tg_id='{$_GET['id']}' 
                             LIMIT 1");


            if (_affected_rows()==1) {
                _close();
//跳转
                _location('恭喜你，删除成功', 'member_message.php');
            }else{
                _close();
//跳转
                _alert_back('短信删除失败');

            }

        }else{
            _alert_back('非法登陆');
        }
        }else{
        _alert_back('此短信不存在');
    }

}


if(isset($_GET['id'])){
  $_rows=_fetch_array("SELECT 
                   tg_id,
                   tg_state,
                   tg_fromuser,
                   tg_content,
                   tg_date
                FROM 
                   tg_message
                WHERE 
                   tg_id='{$_GET['id']}'
                LIMIT 1
                ");
  if ($_rows){
      if (empty($_rows['state'])){
          _query("UPDATE 
                              tg_message 
                           SET 
                              tg_state=1
                          WHERE 
                              tg_id='{$_GET['id']}' 
                              LIMIT 1");
          if (!_affected_rows()){
              _alert_back('异常');
          }


      }
$_html=array();
      $_html['id']= $_rows['tg_id'];
      $_html['fromuser']=$_rows['tg_fromuser'];
      $_html['content']=$_rows['tg_content'];
      $_html['date']=$_rows['tg_date'];
      $_html=_html($_html);
  }else{
      _alert_back('此短信不存在');
  }
}else{
    _alert_back('非法登陆');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" " http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns=" http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <?php
    require ROOT_PATH.'includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/member_message_detail.js"></script>
</head>
<body>
<?php
require ROOT_PATH.'includes/header.inc.php';
?>
<div id="member">
    <?php
    require ROOT_PATH.'includes/member.inc.php';
    ?>
<div id="member_main">
    <h2>短信详情中心</h2>
    <dl>
        <dd>发信人:<?php echo $_html['fromuser']?></dd>
        <dd>内容:<strong><?php echo $_html['content']?></strong></dd>
        <dd>时间:<?php echo $_html['date']?></dd>
        <dd class="button"><input type="button" value="返回列表" id="return"/><input type="button" value="删除短信"  id="delete" name="<?php echo $_html['id']?>"/></dd>
    </dl>

</div>
</div>
<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>


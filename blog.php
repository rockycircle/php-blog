<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/17
 * Time: 13:34
 */
session_start();
define('IN_TG',true);

define('SCRIPT','blog');
require dirname(__FILE__).'/includes/common.inc.php';

//echo $_SERVER["script_NAME"];



//if(isset($_GET['page'])){
//    $_page=$_GET['page'];
//    if(empty($_page)||$_page<0||!is_numeric($_page)){
//        $_page=1;
//    }else{
//        $_page=intval($_page);
//    }
//}else{
//    $_page=1;
//}
//$_pagesize=10;
//$_num=_num_rows(_query("SELECT tg_id FROM tg_user"));
//if ($_num==0){
//    $_pageabsolute=1;
//}else{
//    $_pageabsolute=ceil($_num/$_pagesize);
//}
//if($_page>$_pageabsolute){
//    $_page = $_pageabsolute;
//}
//$_pagenum=($_page-1)*$_pagesize;

global $_pagenum,$_pagesize,$_system;
_page("SELECT tg_id FROM tg_user",$_system['blog']);


$_result=_query("SELECT 
                         tg_id,
                         tg_username,
                         tg_face,
                         tg_sex 
                      FROM 
                         tg_user 
                      ORDER BY 
                         tg_reg_time 
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
    <script type="text/javascript" src="js/blog.js"></script>
</head>
<body>
<?php
require ROOT_PATH.'includes/header.inc.php';
?>

<div id="blog">
    <h2>博友列表</h2>
<?php
   $_html =array();
while(!!$_rows=_fetch_array_list($_result)){

    $_html['id']=$_rows['tg_id'];
    $_html['username']=$_rows['tg_username'];
    $_html['face']=$_rows['tg_face'];
    $_html['sex']=$_rows['tg_sex'];
    $_html=_html($_html);

    ?>
    <dl>
        <dd class="user"><?php echo $_html['username']?>(<?php echo $_html['sex']?>)</dd>
        <dt><img src="<?php echo $_html['face']?>" alt=""/></dt>
        <dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html["id"]?>">发消息</a></dd>
        <dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html["id"]?>">加为好友</a></dd>
        <dd class="guest">写留言</dd>
        <dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html["id"]?>">给她送花</a></dd>
    </dl>
<?php }
_free_result($_result);
_paging(2);
?>



<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>

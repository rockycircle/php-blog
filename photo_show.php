<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/17
 * Time: 13:34
 */
session_start();
define('IN_TG',true);

define('SCRIPT','photo_show');
require dirname(__FILE__).'/includes/common.inc.php';

if (isset($_GET['id'])){
    if(!!$_rows=_fetch_array("SELECT
                                     tg_id
                                       FROM
                                       tg_dir
                                       WHERE
                                       tg_id='{$_GET['id']}'
                                       LIMIT
                                       1
                                       "))
    {
        $_html=array();
        $_html['id']=$_rows['tg_id'];
        $_html=_html($_html);

     }else{
        _alert_back('不存在此相册');
}}else{
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
    <script type="text/javascript" src="js/blog.js"></script>
</head>
<body>
<?php
require ROOT_PATH.'includes/header.inc.php';
?>

<div id="photo">
    <h2>图片展示</h2>

 <p><a href="photo_add_img.php?id=<?php echo $_html['id']?>">上传图片</p>
</div>

<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>

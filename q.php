<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/13
 * Time: 20:54
 */
session_start();
define('IN_TG',true);

define('SCRIPT','q');
require dirname(__FILE__).'/includes/common.inc.php';

if(isset($_GET['num'])&&isset($_GET['path'])){
    if (!is_dir(ROOT_PATH.$_GET['path'])){
        _alert_back('非法操作');
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
    <SCRIPT type="text/javascript" src="js/qopener.js "></SCRIPT>
</head>
<body>

<div id="q">
    <h3>选择Q图</h3>
    <dl>
        <?php foreach (range(1,$_GET['num'])as$_num) {?>
        <dd><img src="<?php echo $_GET['path'].$_num?>.jpg" alt="<?php echo $_GET['path'].$_num?>.jpg" title="头像<?php echo $_num?>" /></dd>
    <?php }?>
    </dl>
</div>

</body>
</html>

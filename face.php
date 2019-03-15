<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/13
 * Time: 20:54
 */
define('IN_TG',true);

define('SCRIPT','face');
require dirname(__FILE__).'/includes/common.inc.php';

foreach(range(1,9)as $number){

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" " http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns=" http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <?php
    require ROOT_PATH.'includes/title.inc.php';
    ?>
    <SCRIPT type="text/javascript" src="js/opener.js "></SCRIPT>
</head>
<body>

<div id="face">
    <h3>选择头像</h3>
    <dl>
        <?php foreach (range(1,9)as$num) {?>
        <dd><img src="face/<?php echo $num?>.jpg" alt="face/<?php echo $num?>.jpg" title="头像<?php echo $num?>" /></dd>
    <?php }?>
    </dl>
</div>

</body>
</html>

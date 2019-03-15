<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/13
 * Time: 15:39
 */
if(!defined('IN_TG')){
    exit('Access Defined');
}

_close();

?>
<div id="footer">
    <p>本程序执行耗时<?php echo round(_runtime()-START_TIME,4); ?></p>
    <p>版权所有 翻版必究</p>

</div>

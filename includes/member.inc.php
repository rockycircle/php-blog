<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/18
 * Time: 16:56
 */
if(!defined('IN_TG')){
    exit('Access Defined');
}


?>

<div id="member_sidebar">
    <h2>中心导航</h2>
    <dl>
        <dt>账号管理</dt>
        <dd><a href="member.php">个人信息</a></dd>
        <dd><a href="member_modify.php">修改资料</a></dd>
    </dl>
    <dl>
        <dt>其他管理</dt>
        <dd><a href="member_message.php">短信查阅</a></dd>
        <dd><a href="member_friend.php">好友设置</a></dd>
        <dd><a href="member_flower.php">查询花朵</a></dd>
        <dd><a href="###">个人相册</a></dd>
    </dl>
</div>

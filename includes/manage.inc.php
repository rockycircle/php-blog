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
    <h2>管理导航</h2>
    <dl>
        <dt>系统管理</dt>
        <dd><a href="manage.php">后台首页</a></dd>
        <dd><a href="manage_set.php">系统设置</a></dd>
    </dl>
    <dl>
        <dt>会员管理</dt>
        <dd><a href="manage_member.php">会员列表</a></dd>
        <dd><a href="manage_job.php">职务设置</a></dd>
    </dl>
</div>

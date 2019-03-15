<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/13
 * Time: 15:33
 */
 if(!defined('IN_TG')){
     exit('Access Defined');
 }

?>
<div id="header">
    <h1><a href="index.php">多用户留言系统--首页</a></h1>
    <ul>
        <li><a href="index.php">首页</a></li>
        <?php
        if (isset($_COOKIE['username'])){

            echo '<li><a href="member.php">'.$_COOKIE['username'].'-个人中心</a>'.$GLOBALS['message'].'</li>';
       echo "\n";
        }else{
            echo '<li><a href="register.php">注册</a></li>';
            echo "\n";
            echo "\t\t";
            echo '<li><a href="login.php">登陆</a></li>';
            echo "\n";
        }
        ?>
        <li><a href="blog.php">博友</a></li>
        <li><a href="photo.php">相册</a></li>
        <li>风格</li>

        <?php

        if(isset($_COOKIE['username'])&&isset($_SESSION['admin'])){
            echo '<li><a href="manage.php" class="manage">管理  </li>' ;
        }

        if (isset($_COOKIE['username'])){
            echo '<li><a href="logout.php">退出</a></li>';
        }

        ?>

    </ul>

</div>

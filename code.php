<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/14
 * Time: 12:57
 */
session_start();
define('IN_TG',true);


require dirname(__FILE__).'/includes/global.func.php';

_code();
////随机码的个数
//$_rnd_code = 4;
//$_nmsg = '';
//for ($i = 0; $i < 4; $i++) {
//    $_nmsg .= dechex(mt_rand(0, 15));
//}
//
//$_SESSION['code'] = $_nmsg;
//
//
//$_width = 75;
//$_height = 25;
//$_img = imagecreatetruecolor($_width, $_height);
//
//$_white = imagecolorallocate($_img, 255, 255, 255);
//
//imagefill($_img, 0, 0, $_white);
//
//$_flag = false;
//if ($_flag) {
//    $_black = imagecolorallocate($_img, 0, 0, 0);
//    imagerectangle($_img, 0, 0, $_width - 1, $_height - 1, $_black);
//}
//
////$_black=imagecolorallocate($_img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
////imagerectangle($_img,0,0,$_width-1,$_height-1,$_black);
//
//for ($i = 0; $i < 6; $i++) {
//    $_rnd_color = imagecolorallocate($_img, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
//    imageline($_img, mt_rand(0, $_width), mt_rand(0, $_height), mt_rand(0, $_width), mt_rand(0, $_height), $_rnd_color);
//}
//
////随机雪花
//for ($i = 0; $i < 100; $i++) {
//    $_rnd_color = imagecolorallocate($_img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
//    imagestring($_img, 1, mt_rand(1, $_width), mt_rand(1, $_height), '*', $_rnd_color);
//
//}
//
////输出验证码
//for ($i = 0; $i < strlen($_SESSION['code']); $i++) {
//    $_rnd_color = imagecolorallocate($_img, mt_rand(0, 100), mt_rand(0, 150), mt_rand(0, 200));
//    imagestring($_img, 5, $i * $_width / $_rnd_code + mt_rand(1, 10), mt_rand(1, $_height / 2), $_SESSION['code'][$i], $_rnd_color);
////    imagestring($_img,5,$i,$i,$_SESSION['code'][$i],imagecolorallocate($_img,0,0,0));
//}
//
//
//header('Content-Type:image/png');
//imagepng($_img);
//
//imagedestroy($_img);
//




?>
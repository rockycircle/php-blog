<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/13
 * Time: 17:02
 */



function _manage_login(){
    if (!isset($_COOKIE['username'])||!isset($_SESSION['admin']))
    {
        _alert_back('非法登陆');
    }
}



function _timed($_now_time,$_pretime,$_second){

    if ($_now_time-$_pretime<$_second){
        _alert_back("请阁下休息一会再发帖");
    }
}


function _runtime(){
    $_mtime = explode(' ',microtime());
   return $_mtime[1]+$_mtime[0];
}

/*
 * _alert_black()表是js弹窗
 * @access public
 * @param $_info
 * @return void 弹窗
 *
 * */




function _alert_back($_info){

        echo "<script type='text/javascript'>alert('$_info');history.back();</script>";
        exit();

}

function _alert_close($_info){

    echo "<script type='text/javascript'>alert('$_info');window.close();</script>";
    exit();

}


function _location($_info,$_url){
   if(!empty($_info)) {
       echo "<script type='text/javascript'>alert('$_info');location.href='$_url';</script>";
       exit();
   }else{
       header('Location:'.$_url);

   }
}

function _login_state(){
    if(isset($_COOKIE['username'])){
        _alert_back('登录状态无法进行本操作');
    }
}

function _uniqid($_mysql_uniqid,$_cookie_uniqid){
    if($_mysql_uniqid!=$_cookie_uniqid){
        _alert_back('唯一标识符异常');
    }
}

function _get_xml($_xmlfile){
//    $_xmlfile = 'new.xml';
    $_html=array();
    if(file_exists($_xmlfile)){
        $_xml=file_get_contents($_xmlfile);
        preg_match_all('/<vip>(.*)<\/vip>/s',$_xml,$_dom);

        foreach($_dom[1] as $_value){
            preg_match_all('/<id>(.*)<\/id>/s',$_value,$_id);
            preg_match_all('/<username>(.*)<\/username>/s',$_value,$_username);
            preg_match_all('/<sex>(.*)<\/sex>/s',$_value,$_sex);
            preg_match_all('/<face>(.*)<\/face>/s',$_value,$_face);
            preg_match_all('/<email>(.*)<\/email>/s',$_value,$_email);
            preg_match_all('/<url>(.*)<\/url>/s',$_value,$_url);

            $_html['id']=$_id[1][0];
            $_html['username']=$_username[1][0];
            $_html['sex']=$_sex[1][0];
            $_html['face']=$_face[1][0];
            $_html['email']=$_email[1][0];
            $_html['url']=$_url[1][0];

        }
    }else{
        echo '文件不存在';
    }
    return $_html;
}

function _set_xml($_xmlfile,$_clean){
    $_fp=@fopen('new.xml','w');
    if (!$_fp){
        exit('系统错误，文件不存在');
    }
    flock($_fp,LOCK_EX);
    $_string="<?xml version=\"1.0\"encoding=\"utf-8\"?>\r\n";
    fwrite($_fp,$_string,strlen($_string));
    $_string="<vip>\r\n";
    fwrite($_fp,$_string,strlen($_string));
    $_string="\t<id>{$_clean['id']}</id>\r\n";
    fwrite($_fp,$_string,strlen($_string));
    $_string="\t<username>{$_clean['username']}</username>\r\n";
    fwrite($_fp,$_string,strlen($_string));
    $_string="\t<sex>{$_clean['sex']}</sex>\r\n";
    fwrite($_fp,$_string,strlen($_string));
    $_string="\t<face>{$_clean['face']}</face>\r\n";
    fwrite($_fp,$_string,strlen($_string));
    $_string="\t<email>{$_clean['email']}</email>\r\n";
    fwrite($_fp,$_string,strlen($_string));
    $_string="\t<url>{$_clean['url']}</url>\r\n";
    fwrite($_fp,$_string,strlen($_string));
    $_string="</vip>\r\n";
    fwrite($_fp,$_string,strlen($_string));
    flock($_fp,LOCK_UN);
    fclose($_fp);
}


function _ubb($_string){
    $_string = nl2br($_string);
    $_string= preg_replace('/\[b\](.*)\[\/b\]/U','<strong>\1</strong>',$_string);
    $_string= preg_replace('/\[color(.*)\](.*)\[\/color\]/U','<span style="color:\1">\2</span>',$_string);
    return $_string;
}

//标题截取函数
function _title($_string,$_strlen)
{
    if (mb_strlen($_string, 'utf8')>$_strlen) {
        $_string = mb_substr($_string, 0, $_strlen, 'utf-8').'...';
    }
return $_string;
}


function _html($_string){
    if(is_array($_string)){
   foreach ($_string as $_key=>$_value){
       $_string[$_key]=_html($_value);
   }
    }else{
   $_string= htmlspecialchars($_string);
}
return $_string;
}


function _mysql_string($_string){
      if(!GPC) {
          //     return mysql_real_escape_string($_string);

          if (is_array($_string)) {
              foreach ($_string as $_key => $_value) {
                  $_string[$_key] = _html($_value);
              }
          } else {
              $_string = mysql_real_escape_string($_string);
          }
      }
    return $_string;

}

function _page($_sql,$_size){
    global $_pagenum,$_pagesize,$_num,$_pageabsolute,$_page;
    if(isset($_GET['page'])){
        $_page=$_GET['page'];
        if(empty($_page)||$_page<=0||!is_numeric($_page)){
            $_page=1;
        }else{
            $_page=intval($_page);
        }
    }else{
        $_page=1;
    }
    $_pagesize=$_size;
    $_num=_num_rows(_query($_sql));
    if ($_num==0){
        $_pageabsolute=1;
    }else{
        $_pageabsolute=ceil($_num/$_pagesize);
    }
    if($_page>$_pageabsolute){
        $_page = $_pageabsolute;
    }
    $_pagenum=($_page-1)*$_pagesize;
//    $_result=_query("SELECT tg_username,tg_face,tg_sex FROM tg_user ORDER BY tg_reg_time DESC LIMIT $_pagenum,$_pagesize");


}


function _paging($_type){
global  $_page,$_pageabsolute,$_num,$_id;
    if($_type==1){
echo'<div id="page_num">';
echo '<ul>';
for ($i=0;$i<$_pageabsolute;$i++){
    if ($_page==$i+1){
        echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($i+1).' " class="selected">'.($i+1).'</a></li>';

    }else {

        echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page=' . ($i + 1) . ' ">' . ($i + 1) . '</a></li>';
    }
}
echo'</ul>';
echo '</div>';
    }
    else if($_type==2){
echo '<div id="page_text">';
echo    '<ul>';
       echo '<li>  '.$_page.'/'.$_pageabsolute.'页</li>';
        echo '<li>共有<strong> '.$_num.'</strong>个会员</li>';

        if($_page==1){
            echo '<li>首页|</li>';
            echo '<li>上一页|</li>';}
        else{
            echo '<li><a href="'.SCRIPT.'.php">首页</a>|</li>';
            echo '<li><a href="'.SCRIPT.'.php?'.$_id.'pag='.($_page-1).'">上一页</a>|</li>';
        }
        if($_page==$_pageabsolute){
            echo '<li>下一页|</li>';
            echo '<li>尾页</li>';
        }else{
            echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page+1).'">下一页</a>|</li>';
            echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.$_pageabsolute.'">尾页</a></li>';
        }

    echo '</ul>';
    echo '</div>';
    }


}



function _session_destroy(){
    if(session_start()){
    session_destroy();
    }
}


function _unsetcookies(){
    setcookie('username','',time()-1);
    setcookie('uniqid','',time()-1);
    _session_destroy();
    _location(null,'index.php');
}



function _sha1_uniqid($_string){

    return _mysql_string(sha1(uniqid(rand(),true)));
}

//function _mysql_string($_string){
//    if(!GPC){
//     return mysql_real_escape_string($_string);
//    }
//    return $_string;
//}






function _check_code($_first_code,$_end_code){
    if ($_first_code!=$_end_code){
        _alert_back('验证码不正确');
    }
}




function _code(    $_width = 75,
    $_height = 25 , $_rnd_code = 4)
{
    //随机码的个数

    $_nmsg = '';
    for ($i = 0; $i < $_rnd_code; $i++) {
        $_nmsg .= dechex(mt_rand(0, 15));
    }

    $_SESSION['code'] = $_nmsg;



    $_img = imagecreatetruecolor($_width, $_height);

    $_white = imagecolorallocate($_img, 255, 255, 255);

    imagefill($_img, 0, 0, $_white);

    $_flag = false;
    if ($_flag) {
        $_black = imagecolorallocate($_img, 0, 0, 0);
        imagerectangle($_img, 0, 0, $_width - 1, $_height - 1, $_black);
    }

//$_black=imagecolorallocate($_img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
//imagerectangle($_img,0,0,$_width-1,$_height-1,$_black);

    for ($i = 0; $i < 6; $i++) {
        $_rnd_color = imagecolorallocate($_img, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
        imageline($_img, mt_rand(0, $_width), mt_rand(0, $_height), mt_rand(0, $_width), mt_rand(0, $_height), $_rnd_color);
    }

//随机雪花
    for ($i = 0; $i < 100; $i++) {
        $_rnd_color = imagecolorallocate($_img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
        imagestring($_img, 1, mt_rand(1, $_width), mt_rand(1, $_height), '*', $_rnd_color);

    }

//输出验证码
    for ($i = 0; $i < strlen($_SESSION['code']); $i++) {
        $_rnd_color = imagecolorallocate($_img, mt_rand(0, 100), mt_rand(0, 150), mt_rand(0, 200));
        imagestring($_img, 5, $i * $_width / $_rnd_code + mt_rand(1, 10), mt_rand(1, $_height / 2), $_SESSION['code'][$i], $_rnd_color);
//    imagestring($_img,5,$i,$i,$_SESSION['code'][$i],imagecolorallocate($_img,0,0,0));
    }


    header('Content-Type:image/png');
    imagepng($_img);

    imagedestroy($_img);

}



?>
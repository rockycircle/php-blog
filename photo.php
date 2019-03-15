<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/17
 * Time: 13:34
 */
session_start();
define('IN_TG',true);

define('SCRIPT','photo');
require dirname(__FILE__).'/includes/common.inc.php';
//读取数据
global $_pagenum,$_pagesize,$_system;
_page("SELECT tg_id FROM tg_dir",$_system['photo']);
$_result=_query("SELECT 
                         tg_id,
                         tg_name,
                         tg_type,
                         tg_face
                      FROM 
                         tg_dir 
                      ORDER BY 
                         tg_date 
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

<div id="photo">
    <h2>相册列表</h2>
    <?php
    $_html =array();
    while(!!$_rows=_fetch_array_list($_result)){

    $_html['id']=$_rows['tg_id'];
    $_html['name']=$_rows['tg_name'];
    $_html['type']=$_rows['tg_type'];
   $_html['face']=$_rows['tg_face'];
    $_html=_html($_html);
if (empty($_html['type'])){
    $_html['type_html']='{公开}';
}else{
    $_html['type_html']='{私密}';
}
if (empty($_html['face'])){
    $_html['face_html']='';
}else{
    $_html['face_html']='<img src="'.$_html['face'].'" alt="'.$_html['tg_name'].'">';
}

    ?>
    <dl>
        <dt><a href="photo_show.php?id=<?php echo $_html['id']?>"><?php $_html['face_html'] ?></a></dt>
        <dd><a href="photo_show.php?id=<?php echo $_html['id']?>"><?php echo $_html['name'] ?><?php echo $_html['type_html']?></a></dd>
        <?php if(isset($_COOKIE['username'])&&isset($_SESSION['admin'])){
        ?>
            <dd>[<a href="photo_modify_dir.php?id=<?php echo $_html['id']?>">修改</a>][删除]</dd>
        <?php }?>
    </dl>
<?php }?>
    <?php if (isset($_SESSION['admin'])&&isset($_COOKIE['username'])) ?>
    <p><a href="photo_add_dir.php">添加目录</p>
</div>

<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>

<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/13
 * Time: 20:40
 */
if(!defined('IN_TG')){
    exit('Access Define');
}

if(!defined('SCRIPT')){
    exit('Script Error');
}
global $_system;
?>
<title><?php echo $_system['webname'] ?></title>
<link rel="stylesheet" type="text/css" href="styles/1/basic.css"  />
<link rel="stylesheet" type="text/css" href="styles/1/<?php echo SCRIPT?>.css"  />


<?php
/**
 * Created by PhpStorm.
 * User: scotte
 * Date: 2017/8/24
 * Time: 19:55
 */
if(!defined('IN_TG')){
    exit('Access Defined');
}
?>
<div id="ubb">
                            <img src="images/wt1.jpg" title="字体大小" alt="字体大小"/>
                            <img src="images/wt1.jpg" title="线条" alt="线条"/>
                            <img src="images/wt2.jpg" title="粗体"/>
                            <img src="images/wt2.jpg" title="斜体"/>
                            <img src="images/wt2.jpg" title="下滑线"/>
                            <img src="images/wt2.jpg" title="删除线"/>
                            <img src="images/wt1.jpg" title="超链接"/>
                            <img src="images/wt1.jpg" title="图片" />

                        </div>
                        <div id="font">
                            <strong onclick="font(10)">10px</strong>
                            <strong onclick="font(12)">12px</strong>
                            <strong onclick="font(14)">14px</strong>
                            <strong onclick="font(16)">16px</strong>
                            <strong onclick="font(18)">18px</strong>
                            <strong onclick="font(20)">20px</strong>
                        </div>
                        <div id="color">
                            <strong title="黑色" style="background: #000" onclick="showcolor('#000')"></strong>
                            <strong title="褐色" style="background: #930" onclick="showcolor('#930')"></strong>
                            <em><input type="text" name="t" value="#"></em>

                        </div>


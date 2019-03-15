window.onload=function(){
     var up = document.getElementById('up');
     up.onclick=function () {
         centerWindow('upimg.php','up','200','400');
     };
     var fm=document.getElementsByTagName('form')[0];
     fm.onsubmit=function () {
         if(fm.name.value.length<2||fm.name.value.length>20){
             alert('图片名不得大于2位或于20位');
             fm.name.value='';//清空
             fm.name.focus();//将焦点移至表单字段
             return false;
         }
         if(fm.url.value==''){
             alert('url不能为空');
             fm.name.focus();//将焦点移至表单字段
             return false;
         }
         return true;
     };

};

function centerWindow(url,name,height,width) {
    var left=(screen.width-width)/2;
    var top=(screen.height-height)/2;
    window.open(url,name,'height='+height+',width='+width+',top='+top+',left='+left);
}
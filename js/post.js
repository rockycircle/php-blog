window.onload=function () {
code();
var ubb = document.getElementById('ubb');
var ubbimg =ubb.getElementsByTagName('img');
    var fm =document.getElementsByTagName('form')[0];
   var font = document.getElementById('font');
    var color = document.getElementById('color');
    var html =document.getElementsByTagName('html')[0];

    fm.onsubmit=function(){
        if(fm.title.value.length<2||fm.title.value.length>40){
            alert('用户名不得大于2位或于40位');
            fm.title.value='';//清空
            fm.title.focus();//将焦点移至表单字段
            return false;
        }
        if(fm.content.value.length<10){
            alert('用户名不得小于10位');
            fm.content.value='';//清空
            fm.content.focus();//将焦点移至表单字段
            return false;
        }
        if(fm.code.value.length!=4){
            alert('验证码必须4位');
            fm.code.value = '';//清空
            fm.code.focus();//将焦点移至表单字段
            return false;
        }
        return true;

    };


    var q=document.getElementById('q');
var qa = q.getElementsByTagName('a');


    html.onmouseup=function () {
        font.style.display = 'none';
        color.style.display = 'none';
    };


    qa[0].onclick=function (){
    window.open('q.php?&num=1&path=qpic/1/','q','width=400,height=400,scrollbars=1');
};




    ubbimg[0].onclick=function () {
        font.style.display = 'block';

    };
    ubbimg[2].onclick=function () {
        content('[b][/b]');
    };
    ubbimg[3].onclick=function () {
        content('[i][/i]');
    };
    ubbimg[4].onclick=function () {
        content('[u][/u]');
    };
    ubbimg[5].onclick=function () {
        content('[s][/s]');
    };
    ubbimg[6].onclick=function () {
        var url = prompt('请输入网址，','http://');
        if (url){
            if (/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(fm.url.value)) {
                content('[url]' + url + '[/url]');
            }else{
                alert ('网址不合法');
            }
        }
    };
    ubbimg[7].onclick=function () {
        color.style.display = 'block';
        fm.t.focus();
    };
function  content(string) {
    fm.content.value+=string;

};
// fm.onclick=function () {
//     showcolor(this.value);
// };


};
function font(size)
{
     document.getElementsByTagName('form')[0].content.value += '[size'+size+'][/size]'

};
function showcolor(value) {
    document.getElementsByTagName('form')[0].content.value += '[color'+value+'][/color]'

};
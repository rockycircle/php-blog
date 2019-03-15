window.onload=function(){
code();
var fm = document.getElementsByTagName('form')[0];
fm.onsubmit = function(){
    if(fm.password.value!=''){
        if(fm.password.value.length<6){
            alert('密码不得小于6位');
            fm.password.value='';
            fm.password.focus();
            return false;
        }
    }
    if(/^[\w\-\.]+@[\w\-\.]+(\.\w+)$/.test(fm.email)) {
        alert('邮件格式不正确');
        fm.email.value = '';//清空
        fm.email.focus();//将焦点移至表单字段
        return false;
    }
    if(fm.qq.value!='') {
        if (!/^[1-9]{1}[0-9]{4,9}$/.test(fm.qq.value)) {
            alert('QQ号码格式不正确');
            fm.qq.value = '';//清空
            fm.qq.focus();//将焦点移至表单字段
            return false;
        }
    }
    if(fm.url.value!='') {
        if (!/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(fm.url.value)) {
            alert('url格式不正确');
            fm.url.value = '';//清空
            fm.url.focus();//将焦点移至表单字段
            return false;
        }
    }
    if(fm.code.value.length!=4){
        alert('验证码必须4位');
        fm.code.value = '';//清空
        fm.code.focus();//将焦点移至表单字段
        return false;
    }
    return true;
};
};
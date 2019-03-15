window.onload=function() {

    code();

    //登陆验证
    var fm=document.getElementsByTagName('form')[0];
    fm.onsubmit= function () {
        if(fm.username.value.length<2||fm.username.value.length>20){
            alert('用户名不得小于2位或大于20位');
            fm.username.value='';//清空
            fm.username.focus();//将焦点移至表单字段
            return false;
        }
        if(/[<>\'\"\   ]/.test(fm.username.value)){
            alert('用户名不得包含敏感字符');
            fm.username.value='';//清空
            fm.username.focus();//将焦点移至表单字段
            return false;
        }
        if(fm.password.value.length<6){
            alert('密码不得小于6位');
            fm.password.value='';//清空
            fm.password.focus();//将焦点移至表单字段
            return false;
        }
        if(fm.code.value.length!=4){
            alert('验证码必须4位');
            fm.code.value = '';//清空
            fm.code.focus();//将焦点移至表单字段
            return false;
        }
    }
};
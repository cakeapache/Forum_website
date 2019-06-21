mesg = document.getElementById('rem');
mail_icon = document.getElementById('envelope');
key1_icon = document.getElementById('key1');
key2_icon = document.getElementById('key2');
user_icon = document.getElementById('user');
card_icon = document.getElementById('card');

function checkEmail(email){
    pattern=new RegExp(/^([a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})*$/);
   mail = document.getElementById('mail');
    if(!pattern.test(email)){
        mesg.innerHTML="請依照Email格式輸入!";
        mail.classList.add("invalid");
        mail.classList.remove("valid");
        mail_icon.className = 'fa fa-envelope fa-lg fa-fw';
        return false;
    }else if(email.length==0){
        mesg.innerHTML="Email為空";
        mail.classList.add("invalid");
        mail.classList.remove("valid");
        mail_icon.className = 'fa fa-envelope fa-lg fa-fw';
        return false;
    }
    else{
        mesg.innerHTML="";
        mail.classList.remove("invalid");
        mail.classList.add("valid");
        mail_icon.className = 'fa fa-check fa-lg fa-fw';
        return true;
    }
    
}
function checkpassword1(password1){
    pattern=new RegExp(/^[a-zA-Z]\w{5,17}$/);
    pas1 = document.getElementById('pas1');
    if(!pattern.test(password1)){
        pas1.classList.add("invalid");
        pas1.classList.remove("valid");
        key1_icon.className = 'fa fa-key fa-lg fa-fw';
        mesg.innerHTML="密碼必需以字母開頭，長度在6~18之間以數字及字母組成!!";
        return false;
    }else if(password1.length==0){
        pas1.classList.add("invalid");
        pas1.classList.remove("valid");
        key1_icon.className = 'fa fa-key fa-lg fa-fw';
        mesg.innerHTML="密碼不能為空!!";
        return false;
    }else{
        mesg.innerHTML="";
        pas1.classList.add("valid");
        pas1.classList.remove("invalid");
        key1_icon.className = 'fa fa-check fa-lg fa-fw';
        return true;
    }
}
function checkpassword2(password2){
    pattern=document.getElementById('Tpas1').value;
    pas2 = document.getElementById('pas2');
    if(password2==pattern&&password2!='' && checkpassword1(pattern)){
        mesg.innerHTML="";
        pas2.classList.remove("invalid");
        pas2.classList.add("valid");
        key2_icon.className = 'fa fa-check fa-lg fa-fw';
        return true;
    } else if(!checkpassword1(pattern)){
        pas2.classList.add("invalid");
        pas2.classList.remove("valid");
        key2_icon.className = 'fa fa-key fa-lg fa-fw';
        mesg.innerHTML="密碼格式錯誤!!";
        return false;
    } else{
        pas2.classList.add("invalid");
        pas2.classList.remove("valid");
        key2_icon.className = 'fa fa-key fa-lg fa-fw';
        mesg.innerHTML="請重複上面的密碼!!";
        return false;
    }
}
function checknickname(nickname){
    nick = document.getElementById('nickN');
    if(nickname.length==0){
        nick.classList.add("invalid");
        nick.classList.remove("valid");
        card_icon.className = 'fa fa-address-card fa-lg fa-fw';
        mesg.innerHTML="請輸入暱稱!!";
        return false;
    }else{
        mesg.innerHTML="";
        nick.classList.add("valid");
        nick.classList.remove("invalid");
        card_icon.className = 'fa fa-check fa-lg fa-fw';
        return true;
    }
}
function checkaccount(account){
    pattern=new RegExp(/^[a-zA-Z]\w{5,17}$/);
    user = document.getElementById('userN');
    if(!pattern.test(account)){
        user.classList.add("invalid");
        user.classList.remove("valid");
        user_icon.className = 'fa fa-user fa-lg fa-fw';
        mesg.innerHTML="帳號必需以字母開頭，長度在6~18之間以數字及字母組成!!";
        return false;
    }else if(account.length==0){
        mesg.innerHTML="帳號不能為空!!";
        user.classList.add("invalid");
        user.classList.remove("valid");
        user_icon.className = 'fa fa-user fa-lg fa-fw';
        return false;
    }else{
        mesg.html="";
        user.classList.remove("invalid");
        user.classList.add("valid");
        user_icon.className = 'fa fa-check fa-lg fa-fw';
        return true;
    }
}

function validateForm(form){
    if(!checkaccount(form.userN.value)||!checknickname(form.nickN.value)||!checkpassword1(form.pas1.value)||
    !checkpassword2(form.pas2.value)||!checkEmail(form.mail.value)){
        return false;
    }
    else{
        form.submit();
        return true;
    }
}
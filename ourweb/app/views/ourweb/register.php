<body onmousewheel="test()" id='bodyId'>
<?php
    require("loading.php");
    require("loginBar.php");
    if(isset($_COOKIE['session_id'])){
        header("Location:/ourweb/index");
    }
?>
<div class='bak'></div>
<h1 style="float:none; text-align:center; font-weight: bold;">加入會員</h1>
<div class="container animated fadeIn" style="z-index:0; text-align:center; width:450px; border-radius:8px; padding:15px;" id="main-content">
<form class="register" id="register" action='' method="post" onclick="return false">
    
    <div class='inputWithIcon' id="userN">
    <input type='text' placeholder="請輸入用戶名稱" onblur='checkaccount(this.value)' name="userN" id="TuserN" autocomplete="none">
    <i class='fa fa-user fa-lg fa-fw' id = 'user'></i>
    </div>
    <div class='inputWithIcon' id="nickN">
    <input type='text' placeholder="請輸入暱稱" onblur='checknickname(this.value)' name="nickN" id="TnickN" autocomplete="none">
    <i class='fa fa-address-card fa-lg fa-fw' id = "card"></i>
    </div>
    <div class='inputWithIcon' id="pas1">
    <input type='password' placeholder="請輸入您的密碼" onblur='checkpassword1(this.value)' name="pas1" id="Tpas1">
    <i class='fa fa-key fa-lg fa-fw' id = 'key1'></i>
    </div>
    <div class='inputWithIcon' id="pas2">
    <input type='password' placeholder="請再次輸入您的密碼" onblur='checkpassword2(this.value)' name="pas2" id="Tpas2">
    <i class='fa fa-key fa-lg fa-fw' id = 'key2'></i>
    </div>
    <div class='inputWithIcon' id="mail">
    <input type='text' placeholder="請輸入E-mail" onblur='checkEmail(this.value)' name="mail" id="Tmail">
    <i class='fa fa-envelope fa-lg fa-fw' id = 'envelope'></i>
    </div>
    <div id='rem'><?php echo $msg;?></div>
    <input type='submit' value="完成提交" onclick="validateForm(form)" class='submit' style="margin-left: 4px;">
</form>
</div>
</body>
<script  tpye=text/javascript src="/static/js/ourweb/valid.js?v=1"></script>
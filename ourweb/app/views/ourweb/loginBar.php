<div class='jumbotron animated fadeInDown' id='navId' style="z-index:1; background: color:rgb(59, 59, 59 ,0.5); padding:0;">
<h1><a href="/ourweb/index" style="color:black;">CodeHome</a></h1>

<button class='btn'id='but' onclick="pop(false)">Login</button>

<button onclick = "ToRegister()" class='btn' id='reg'>Register</button>


<form class='login animated fast fadeInRight fadeOutRight' id='login' method='post' action=''>
    <div class='inputWithIcon'>
    <input type='text' name='account' class='fildform' placeholder='請輸入帳號'>
    <i class='fa fa-user fa-lg fa-fw' aria-hidden="true"></i><br></div>
    <div class='inputWithIcon'>
    <input type='password' name='password' class='fildform' placeholder='請輸入密碼'>
    <i class='fa fa-key fa-lg fa-fw'></i><br></div>
    <input class='submit' type='submit' name='submit' value='登入'>
</form>


<?php if(isset($_SESSION["account"])){
            ?>
            <button class='btn' value='setting' onclick='setting()'>Setting</button>
            <div class='mem'>Welcome ,<?=$_SESSION['nickname'] ?>!!<br>
            Level : <a style="color:blue;"><?=$_SESSION['level']?></a></div>

            <div class='setting-container animated faster fadeInRight fadeOutRight' id='setting'>
                <h2>Hello,<?=$_SESSION['nickname']?>!!</h2>
            <button class='btn' value='test' onclick='ToJava()'>Java 編譯器</button>
            <button class='btn' value='test' onclick='ToWeb()'>WEB 編譯器</button>
            <button class='btn' value='test'>Test3</button>
            <button class='btn' value='test'>Test4</button>
            <form id='logout' class='info' method='post' action='' >
            <input class='btn' type='submit' name='logout' value='logout' >
            </form>
            </div>




            <script type=text/javascript>
                document.getElementById('but').style.display='none';
                document.getElementById('login').style.display='none';
                document.getElementById('reg').style.display='none';
            </script>

            <?php
        }else{
            if(isset($_SESSION['message'])&&$_SESSION['message']!=''){
            ?>
                <div id='warning'><?=$_SESSION['message'] ?></div>
            <?php
            }
        } ?></div>
<script>
    function ToRegister(){
        window.location = "/ourweb/register";
    }
    function ToJava(){
        window.location = "/compiler/java";
    }
    function ToWeb(){
        window.location = "/compiler/web";
    }
</script>
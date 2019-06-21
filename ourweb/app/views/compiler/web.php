<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="/static/js/compiler/workSpace.js?ver=1>"></script>
</head>
<body onmousewheel="test()" id='bodyId'>

<?php 
    require('./app/views/ourweb/loading.php');
    require('./app/views/ourweb/loginBar.php');
?>
<div class='bak'></div>
<h1 style="float:none; text-align:center; font-weight: bold;">WEB DESIGN</h1>
<div class="container animated fadeIn" style="border-radius:8px; padding:15px; text-align:center;" id="main-content">
    <a style='float:left; margin:2px; margin-left:30px;'>.HTML<br>
    <textarea name="" id="htmlCode" cols="45" rows="10" style='border:3px solid skyblue;' oninput="addCode('htmlCode')"></textarea></a>
    <a style='float:left; margin:2px;'>.CSS<br>
    <textarea name="" id="cssCode" cols="45" rows="10" style='border:3px solid skyblue;' oninput="addCode('cssCode')"></textarea></a>
    <a style='float:left; margin:2px;'>.JS<br>
    <textarea name="" id="jsCode" cols="45" style='border:3px solid skyblue;' rows="10" ></textarea></a>

     <br>
     <br>
    <iframe src="\static\html\html.html" frameborder="1" style='border:1px solid white;' width=95% height=400px id="iframe" onload="addCode('htmlCode');addCode('cssCode');addCode('jsCode');"></iframe>
    <br>
    <input type="button" value="執行js" class='btt' onclick="reloadIframe()">

    <form onclick='return false' >
    <input type='hidden' name='shareDataHTML' id='shareDataHTML'>
    <input type='hidden' name='shareDataCSS' id='shareDataCSS'>
    <input type='hidden' name='shareDataJS' id='shareDataJS'>
    <input type="submit" onclick='shareWeb(form)' class='btt' value='分享'>
    </form>

</div>
</body>
</html>
<style>
.btt{
    display:inline-block;
    outline:none;
    margin:5px 33%;
    height: 40px;
  
    border-radius:20px;
	width:33%;
	background:#1abc9c;

	color:white;
	cursor:pointer;
	
    transition:0.2s ease all;
}
</style>
<script>
    function shareWeb(form){
        a = document.getElementById('shareDataHTML');
        b = document.getElementById('shareDataCSS');
        c = document.getElementById('shareDataJS');

        d = document.getElementById('htmlCode');
        e = document.getElementById('cssCode');
        f = document.getElementById('jsCode');

        a.value = d.value;
        b.value = e.value;
        c.value = f.value;
        
        if(a.value==''&&b.value==''&&c.value==''){
            alert('請分享非空的程式碼:D');
            return false;
        }else{
            form.submit();
        }
    }
</script>
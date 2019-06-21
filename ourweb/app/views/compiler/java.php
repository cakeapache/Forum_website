<link rel='stylesheet' type='text/css' href='/static/css/compiler/autoTextarea.css?v=1'/>
<link rel='stylesheet' type='text/css' href='/static/css/compiler/style.css?v=1'/>
<body onmousewheel="test()" id='bodyId'>

<?php 
    require('./app/views/ourweb/loading.php');
    require('./app/views/ourweb/loginBar.php');
?>

<div class='bak'></div>
<h1 style="float:none; text-align:center; font-weight: bold;">JAVA COMPILER</h1>
<div class="container animated fadeIn" style="border-radius:8px; padding:15px; posit" id="main-content">
<form action="" method="post"  style="display:inline-block; width:100%" spellcheck="false">


 <textarea id="textarea" Cols="100" spellcheck:="false" name="java"  class="textarea javaTextarea" ><?= $java?></textarea>
 <label for="result" style='display:inline-block; '>input</label><label for="stdin" style="position:absolute;left:50%;">result</label><br>
 
 <textarea name="stdin" class='result javaTextarea'  spellcheck:="false" id="" ><?php echo isset($stdin)? $stdin : ''?></textarea>
<div class='textarea javaTextarea result' name='result'> <?php  echo isset($Eresult)? $Eresult : '' ;?></div>
<br><br>
<input type="submit" name="submitJava" class="javaSub " value="編譯" >  
</form>
<form>
<input type='hidden' name='shareData' id='shareData'>
<input type="submit" onclick='share()' class='javaSub' value='分享'>
</form>
</div>

    
<p>





</body>
</html>
<script src="/static/js/compiler/java.js?V=1"></script>
<script src="/static/js/compiler/autoTextarea.js?V=1"></script>
<script> creatLi(['int','float','double','var','String','System.out.println'
                 ,'import','java.util.Scanner','Scanner','new','nextFloat','System.in'
                 ,'nextLine','nextInt','next'],'suggestion','suggestion');test1('textarea','suggestion');</script>

<body onmousewheel="test()" id='bodyId'>

<?php 
    require('./app/views/ourweb/loading.php');
    require('./app/views/ourweb/loginBar.php');
?>


<div class='bak'></div>



<h1 style="float:none; text-align:center; font-weight: bold;"> 板塊名稱 <br><?=$cat_name?></h1>


<div class="controll-panel">
<a href="/ourweb/index">回到首頁</a>
</div>


<div class="container animated fadeIn" style="border-radius:8px; padding:15px; " id="main-content">


<form  id="uploadImage" method="post" enctype='multipart/form-data'>
    檔案名稱:
   <input type="file" name="cat_image" id="" accept="image/gif, image/jpeg, image/png"><br>

    <input type="submit"  value="上傳">
</form>
<p>預覽圖</p>
<div id='view'>
<img id='image_preview' width='300px' height='100px' src=<?=$cat_image?> alt="">
</div>


<form action="" method="post">
<h2 style='text-align:center;'>板塊敘述</h2><br>
<textarea name="cat_description" id="" cols="30" rows="10" style='width:100%;'><?=$cat_description?></textarea><br>
<input type="submit" value="修改" style='margin:0px auto; width:100px;'>
<input type="hidden" name="cat_image" id='cat_image' value=<?=$cat_image?>>
</form>
</div>

<?php

if(isset($result)){
    if($result===0){
        echo 'this error';
    }else{
        header('Location:/ourweb/index');
    }
}
?>
<script type="text/javascript">
    $(document).ready(function (e){
        $("#uploadImage").on('submit',(function(e){
            e.preventDefault();
            $.ajax({
                url: "/forum/uploadImage",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(data){
                    $("#image_preview").attr('src',(JSON.parse(data)).image_path);
                    $("#cat_image").attr('value',(JSON.parse(data)).image_path);
                },
                error: function(){
                }               
            });
        }));
    });
</script>
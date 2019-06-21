<body onmousewheel="test()" id='bodyId'>

<?php 
    require('./app/views/ourweb/loading.php');
    require('./app/views/ourweb/loginBar.php');
?>

<div class='bak'></div>
<h1 style="float:none; text-align:center; font-weight: bold;">CreateCat</h1>
<div class="controll-panel">
<a href="/ourweb/index">回到forum</a>
</div>

<div class="container animated fadeIn" style="border-radius:8px; padding:15px; " id="main-content">
<form  id="uploadImage" method="post" enctype='multipart/form-data'>
    檔案名稱: <input type="file" name="cat_image" id=""><br>
    <input type="submit"  value="上傳">
</form>
<p>預覽圖</p>
<div id='view'>
<img src="" id='image_preview' width='300px' height='100px' alt="">
</div>
<form method="post" action="">
    Category name: <input type="text" name="cat_name" class='fildform' autocomplete="off"/><br><br>
    Category description: <br><textarea name="cat_description" class='area'></textarea><br>
    <input type="hidden" name="cat_image" id='cat_image' >
    <input type="submit" value="Add category">
</form>
    <?php if(isset($result)){
        if($result==0){
        echo "this already create ";}
        else {
            echo "<script type='text/javascript'>";
            echo "window.location= '/ourweb/index'";
            echo "</script>";
        }
    }
        ?>
</div>
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
                    console.log(data);
                    $("#image_preview").attr('src',(JSON.parse(data)).image_path);
                    $("#cat_image").attr('value',(JSON.parse(data)).image_path);
                },
                error: function(){
                }               
            });
        }));
    });
</script>
<link rel='stylesheet' type='text/css' href='/static/css/ourweb/topic.css?v=1'/>
<body onmousewheel="test()" id='bodyId'>

<?php 
    require('./app/views/ourweb/loading.php');
    require('./app/views/ourweb/loginBar.php');
?>


<div class='bak'></div>
<h1 style="float:none; text-align:center; font-weight: bold;">發表文章</h1>
<div class="controll-panel">
<a href="/forum/category/<?=$cat_id?>">回到文章列表</a>
</div>

<div class="container animated fadeIn" style="border-radius:8px; padding:15px; " id="main-content">
<?php
    if(isset($_SESSION['id'])){
?>
<form action="" method="post" id="post" style='text-align:center;' onclick='return false'>
<p>分類子版: <?=$cat_name?></p>
文章標題<br><input type="text" name="topic_subject" id="top_name" autocomplete="off"><br>
文章內容<div contentEditable="true" name="post_content" id="reply" class='post_content'  oninput='change()'></div><br>
<input type="hidden" name="post_content" id='post_content'>
<input type="submit" value="Create topic" onclick='check(form)' id='btsubmit'/>
</form>
<form  id="uploadPostImage" method="post">
    檔案名稱: <input type="file" name="post_image[]"  id="imgInp" accept="image/gif, image/jpeg, image/png" multiple><br>
    <input type="submit" value="上傳圖片">
</form>

<?php
if(isset($resultTop)&&isset($resultPost)){
    if($resultTop==1 && $resultPost==1){
?>
<script>
    window.location = "/forum/category/<?=$cat_id?>";
    function change(){
        $hidden=$("#post_content").val().trim();
        space = document.getElementById('reply');
    $("#post_content").attr('value',space.innerHTML);
    if($hidden.length>225){
        alert("超過225個字了><!!");
    }
}
</script>
<?php    }else if($resultTop==1){
        echo "create topic successful creat post error";
    }else echo"can not create topic and post";
}
    } else{
        echo "登入再來拉><";
    }
?>
</div>
<style>
img{
	width: auto;
	height: auto;
	max-width:300px;
	max-height: 300px;	
}
</style>
<script type="text/javascript">
    function check(form){
        a = document.getElementById('top_name');
        b = document.getElementById('post_content');
        if(a.value==''||b.value==''){
            alert("請輸入內容!!");
        } else{
            form.submit();
        }
    }
function change(){
    $("#post_content").attr('value',document.getElementById('reply').innerHTML);
} 
$(document).ready(function (e){
        $("#uploadPostImage").on('submit',(function(e){
            e.preventDefault();
            $.ajax({
                url: "/forum/uploadPostImage",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(data){
                    console.log(JSON.parse(data));
                    img_array=JSON.parse(data);

                    img_array.forEach( img_path=> {
                        
                
                   var img=document.createElement("img");
                   img.src=img_path;      
                   document.getElementById('reply').appendChild(img);
                   document.getElementById('reply').innerHTML+="<br>";
                   $("#post_content").attr('value',document.getElementById('reply').innerHTML);
             

                   var imgInp=document.createElement('input');
                   imgInp.setAttribute("type", "hidden");
                   imgInp.setAttribute("name", "img[]");
                   imgInp.setAttribute("value",img_path);

                   document.getElementById('post').insertBefore(imgInp,  document.getElementById('btsubmit'));
                    });
                },
                error: function(){
                }               
            });
        }));
    });

</script>
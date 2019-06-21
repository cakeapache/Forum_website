<link rel='stylesheet' type='text/css' href='/static/css/ourweb/topic.css?v=1'/>
<body onmousewheel="test()" id='bodyId'>

<?php 
    require('./app/views/ourweb/loading.php');
    require('./app/views/ourweb/loginBar.php');
    date_default_timezone_set("Asia/Taipei");
?>

<div class='bak'></div>
<h1 style="float:none; text-align:center; font-weight: bold;"><?php echo $topic_subject?></h1>


<div class="controll-panel"><a href="/forum/topic/<?=$cat_id?>/<?=$post_topic?>">回到topic</a></div>



<div class="container animated fadeIn" style="border-radius:8px; padding:15px; margin-bottom:10px;" id="main-content">
<h1 style="float:none; text-align:center; font-weight: bold;">內容</h1>
<form action="" id="post" method="post"  enctype='multipart/form-data' style='text-align:center;'>
<div contentEditable="true" name="post_content" id="reply" class='post_content'  oninput='change()'><?php echo $post_content;?></div><br>
<input type="hidden" name="post_content" id='post_content' value=<?php echo "'".$post_content."'";?>>
<input type="submit" value="修改" id='btsubmit'>
</form>
<br>
<br>
<form  id="uploadPostImage" method="post">
    檔案名稱: <input type="file" name="post_image[]"  id="imgInp" accept="image/gif, image/jpeg, image/png" multiple><br>
    <input type="submit" value="上傳圖片">
</form>
</div>
<?php
if(isset($result)){
    echo "<script type='text/javascript'>";
    echo "window.location= '/forum/topic/".$cat_id."/".$post_topic."'";
    echo "</script>";
}
?>
<style>
.post_content{
    width:500px;
    height:400px;
    border: 1px solid #ccc;
    overflow-y:auto;
    overflow-x:hidden;
}
td{
    border:1px solid black;
}

img{
	width: auto;
	height: auto;
	max-width:300px;
	max-height: 300px;	
}
</style>


<script type="text/javascript">
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
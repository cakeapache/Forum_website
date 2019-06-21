<link rel='stylesheet' type='text/css' href='/static/css/ourweb/topic.css?v=1'/>
<body onmousewheel="test()" id='bodyId'>

<?php 
    require('./app/views/ourweb/loginBar.php');
    date_default_timezone_set("Asia/Taipei");
?>

<div class='loading' id='loadBK' style='position:fixed;width:100%;height:100%;background:rgba(100, 100, 100,0.87);'>
<img class='loading' id='loadCC' src='/static/img/post-loading.gif' style='position:fixed; width:100px; height:100px; left:50%;top:50%; border-radius:15px;'>
</div>

<div class='bak'></div> 


<div class="controll-panel"><a href="/forum/category/<?=$topic_cat?>">回到文章列表</a></div>

<div class="ToBottom"><input type='text' autocomplete='off' placeholder='樓' id='stage' style='text-align:center; background:white; width:80%; height:50%;' /><div class='RBar' id='ToBTM'>&nbsp</div></div>
<div class="container animated fadeIn" style=" border-radius:8px; padding:15px; margin-bottom:10px; background:none" id="main-content">
<center><div id='page'></div></center>
<?php

if(isset($posts)){
    $i=0;
    foreach ($posts as $row) {
        $i++;
        echo "<div class='topic-board' name='board'>";
        if($i==1){?>
            <h1 style='float:none; text-align:center; font-weight: bold;'><?php echo $topic_subject?></h1>
            <?php
            echo "<div class='information' name='info'><small class='stage-tag'>樓主</small>";
        } else{
            echo "<div class='information' name='info'><small class='stage-tag'>".$i."樓</small>";
        }
        echo "<a style='font-size:24px;'>".$row['NICKNAME']." </a>";
        echo "<a style='font-size:12px'>".$row['ACCOUNT']."</a><br>";
        echo "Level: <a style='color:blue;'>".$row['level']."</a><br></div>";
        echo "<div class='article'>".$row['post_content']."</div>";
        echo "<div class='date'><small>";
        if(isset($_SESSION['id'])&&isset($_SESSION['level'])&&($row['post_by']==$_SESSION['id']||$_SESSION['level']=='administrator')&&$i!=1){
            echo "<a style='background:#aaa; color:black;' href='/forum/updatePost/".$topic_cat."/".$row['post_topic']."/".$row['post_id']."'>編輯</a>&nbsp&nbsp";
            echo "<a style='background:#aaa; color:black;' href='/forum/deletePost/".$topic_cat."/".$row['post_topic']."/".$row['post_id']."'>刪除</a>";
        }
        echo "&nbsp&nbsp&nbsp發表時間 : ".$row['post_date']."</small></div>";
        
        echo "</div>";
    }
}
?>
</div>
<?php
    if(isset($flag)&&$flag){
        ?>
    <script>
    alert("請不要重複提交留言!!");
    </script>
    <?php }
    if(isset($_SESSION['id'])){
        $record=mt_rand(0,1000000);
        $_SESSION['record'] = $record;
?>
<div class="container animated fadeIn" style="border-radius:8px; padding:15px; margin-top:30px; text-align:center;" id="main-content1">
<h2>回覆文章</h2>
<form action="" id="post" method="post" name='frame' enctype='multipart/form-data' onclick='return false'>
<div contentEditable="true" name="post_content" id="reply" class='post_content'  oninput='change()'></div><br>
<input type="hidden" name="post_content" id='post_content'>
<input type="hidden" name='originator' value=<?=$record?>>
<input type="submit" value="reply" id='btsubmit' onclick='check()'>
</form>
<button onclick='imgCont()' class='imgBT'>新增圖片</button>
<div class='imageContainer animated fast fadeInUp fadeOutDown' id='imgContainer'>
<form  id="uploadPostImage" method="post">
    檔案名稱: <input type="file" name="post_image[]"  id="imgInp" accept="image/gif, image/jpeg, image/png" multiple><br>
    <input type="submit" value="上傳圖片">
</form>
</div>

<?php
if(isset($result)){
    if($result==1){
        echo "<script>";
        echo "alert('回覆成功´･ᴗ･`!!')";
        echo "</script>";
    }else {
        echo "<script>";
        echo "alert('回覆失敗TAT!!')";
        echo "</script>";
    }
}    
} else{
    echo '<div class="container animated fadeIn" style="border-radius:8px; padding:15px; margin-top:30px; text-align:center;" id="main-content">';
    echo "<h2>登入再留言拉><</h2>";
    echo "</div>";
}
?>
</div>
<script src='/static/js/ourweb/topic.js?v=1'></script>
<script type="text/javascript">
$loading = $('.loading');
setTimeout(()=>{
    $loading.fadeOut();
}, 5000);

function check(){
    a = document.forms['frame']['post_content'].value;
    if(a==''){
        alert("請輸入內容!!");
        return false;
    }else{
        document.forms['frame'].submit();
    }
}
function change(){
    $("#post_content").attr('value',document.getElementById('reply').innerHTML);

} 
$(document).ready(function (e){
    $BK = $('.loadBK');
    $CC = $('.loadCC');
    $BK.show(); $CC.show();
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
                    $BK.hide(); $CC.hide();
                    img_array=JSON.parse(data);

                    img_array.forEach( img_path=> {
                        img_subname= img_path.split('.')[2];
                            if(img_subname=='jpg'||img_subname=='gif'||img_subname=='png'){
                            var img=document.createElement("img");
                            img.src=img_path;
                            document.getElementById('reply').appendChild(img);
                            document.getElementById('reply').innerHTML+="<br>";
                            $("#post_content").attr('value',document.getElementById('reply').innerHTML);
                        }else{
                            var element = document.createElement('a');
                            element.setAttribute('href', img_path);
                            element.setAttribute('download',Date.now());
                            download_name=(document.getElementById('imgInp').value).split("\\");
                            element.innerHTML=download_name[download_name.length-1];
                            document.getElementById('reply').appendChild(element);
                            document.getElementById('reply').innerHTML+="<br>";
                            $("#post_content").attr('value',document.getElementById('reply').innerHTML);
                        }

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
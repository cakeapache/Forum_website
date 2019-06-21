<link rel='stylesheet' type='text/css' href='/static/css/ourweb/topic.css?v=1'/>
<body onmousewheel="test()" id='bodyId'>

<?php 
    require('./app/views/ourweb/loginBar.php');
?>
<style>
img{
	width: auto;
	height: auto;
	max-width:25%;
	max-height: 25%;	
}
</style>
<div class='bak'></div>

<div class='loading' style='position:fixed;width:100%;height:100%;background:rgba(100, 100, 100,0.87);'>
<img class='loading' src='/static/img/post-loading.gif' style='position:fixed; width:100px; height:100px; left:50%;top:50%; border-radius:15px;'>
</div>


<h1 style="float:none; text-align:center; font-weight: bold;"><?php echo $cat_name?></h1>
<div class="controll-panel">
<?php 
    if(isset($_SESSION['level'])){
        echo "<a href='/forum/createTop/$cat_id'>發表文章</a>";
    }

?>
<a href="/ourweb/index">回到首頁</a>
</div>
<div class="container animated fadeIn" style="border-radius:8px; padding:15px; " id="main-content">
<center><div id='page'></div></center>
<table id='tb'>
<?php
if(isset($tops)){
    foreach ($tops as $row) {
        echo '<tr class="TBboard" name="bo" ><td><button class="TopBT" onclick=ToTop("/forum/topic/'.$cat_id.'/'.$row['topic_id'].'")>';
        echo '<h3 class="Mainsub" ><a href="/forum/topic/'.$cat_id.'/'.$row['topic_id'].'" style="color:black;">' . $row['topic_subject'].'</a></h3>';
        echo '<h3 style="text-align:right; font-size:12px;"><a class="info" style="background:yellow;">'.$cat_name."</a>";
        echo '<a class="info" style="background:darkblue;color:white;">'.$row['topic_date']."</a></h3>";
        echo '<h3 class="content-preview"><a style="color:#aaa;" id="post_text'.$row['topic_id'].'">'.$row['post_content']."</a></h3>";
        echo '<h3 class="member" ><a style="margin:0px 1px;">樓主:'. $row['NICKNAME'].'&nbsp&nbsp<small>'.$row['ACCOUNT'].'</small>'.'</a><br>';
        echo '<a style="color:blue">'.$row['level'].'</a></h3>';
        if(isset($_SESSION['id'])&&isset($_SESSION['level'])){
        if($_SESSION['id']==$row['topic_by']||$_SESSION['level']=='administrator'){
            echo"<h3 class='editer' >".'<a class="editer-bt" href="/forum/updateTop/'.$cat_id.'/'.$row['topic_id'].'">編輯</a>';
            echo'<a class="editer-bt" href="/forum/deleteTop/'.$cat_id.'/'.$row['topic_id'].'">刪除</a></h3>';
        }
    }
        echo '</button></td></tr>';
        echo "<script>a = document.getElementById('post_text{$row['topic_id']}');";
        echo "a2= a.innerHTML.replace('</div>','');";
        echo "b = a.getElementsByTagName('img')[0];";
        echo "if(b) a.innerHTML='<img src=\"'+b.src+'\">';";
        echo "else{ a.innerHTML=a2.substr(0,15);";
        echo "if(a.innerHTML.length>=15) a.innerHTML+='...';}";
        echo "</script>";
    }
}else{
    echo "Empty";
}
?>
</table>
</div>
<script>
function ToTop(path){
        window.location=path;
    }
</script>
<script>
parameter = location.href;
if(parameter.indexOf('?')==-1){
    value = 1;
}else{
value = parameter.split('?')[1];
}
tb = document.getElementById('tb');
elements = tb.rows;
page_content = document.getElementById('page');
per = 3;
page = Math.ceil(elements.length/per);
for(i=0 ; i< elements.length;i++){
    elements[i].style.display='none';
}
if(page>1){
    str='<a style="font-size:16px;">第 </a>';
    for( i =1; i<=page;i++){
        str=str+"<a href='?"+i+"' name='label' style='border:1px solid white; border-radius:4px; color:black; font-size:18px; background:rgba(115, 195, 210,0.6); margin:5px; padding:5px;' >"+i+"</a>";
    }
    str=str+'<a style="font-size:16px;">'+"頁"+'</a>';
    page_content.innerHTML=str;
    labels = document.getElementsByName('label');
    for(i = 0 ;i<labels.length;i++){
        if(i+1==value){
            labels[i].style.color='white';
        }
    }
}
for(i=(value-1)*per ; i< per+((value-1)*per);i++){
        elements[i].style.display='table-row';
}
</script>
<body onmousewheel="test()" id='bodyId'>


<?php
    require('loading.php');
    require('loginBar.php');
    require('sideBar.php');
?>
<div class='bak'></div>


<div class='outsideBar'><button href="#main-content" onclick="Page('main-content')" id='bt1'>首頁</button>
<button href="#second-content" onclick="Page('second-content')" id='bt2'>討論區</button></div>



<div class="container animated fadeIn" style="border-radius:8px; padding:15px; " id="main-content">
    <center><div class='text-title' style="text-decoration:none; font-size:48px;">CODEHOME</div></center><br/>
    <div class='text-title'>About Us</div>
    <text>We are a second-year student in the Department of CSIE, NUTN.
          This is our Web programming final report.</text>
    <div class='text-title'>Features</div>
    <text>The features of CODEHOME are online-compilier , codeing sharing , and forum.</text>
    <div class='text-title'>Contact Us</div>
    <text>If there is any trouble,please let us know.You can contact us :
        <br/>&nbsp&nbspe-mail : egg2915978@gmail.com
        <br/>&nbsp&nbspe-mail : jojogo48@gmail.com</text>
        <div class='text-title'>Update Record</div>
    <text>
        <?php require('record.txt');
        ?>
    </text>
</div>

<div class="container animated fadeIn" style="border-radius:8px; padding:15px;"  id="second-content">
<center><div class='text-title' style="text-decoration:none; font-size:48px;">板塊頁面</div></center>

<?php
if(isset($_SESSION['level'])&&$_SESSION['level'] == 'administrator'){
    echo "<div class='controll-panel'>"."<a href=\"/forum/createCat\">creatCat</a></a><br>"."</div>";
}
if(isset($cats)){
    foreach ($cats as $row) {
        echo '<div class="borad" >';
        echo "<button  onclick='ToCategory({$row['cat_id']})' style='border-radius:4px; background-image:url({$row['cat_image']})'>".'</button>';
        echo '<div class="descript"><a href="/forum/category/'.$row['cat_id'].'">' . $row['cat_name'] . '</a>' ;
        if(isset($_SESSION['level'])&&$_SESSION['level'] == 'administrator'){
            echo '<a href="/forum/updateCat/'.$row['cat_id'].'" style="background:skyblue;float:right; margin:5px; border:1px dotted black; color:black;">'.'Update'.'</a>';
            echo '<a href="/forum/deleteCat/'.$row['cat_id'].'" style="background:skyblue;float:right; margin:5px; border:1px dotted black; color:black;">'.'Delete'.'</a>';
        }
        echo '<div class="article"><a';
        if(isset($row['topic_subject'])){
            echo " href=/forum/topic/{$row['cat_id']}/{$row['topic_id']} style='color:black;'>"."[最新文章]".$row['topic_subject'];
            echo "<br>上次更新: ".$row['topic_date'];
        }
        else
            echo ">"."[none]";
        echo"</a></div>";
        echo "<div class='bottomDes'>".$row['cat_description']."</div></div>";
    echo '</div>';
    }
}
?>
</div>

</body>
<script>
    function ToCategory(type){
        window.location = "/forum/category/"+type;
    }
</script>
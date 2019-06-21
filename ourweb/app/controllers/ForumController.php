<?php
 namespace app\controllers;
 use fastphp\db\Db;
 use fastphp\base\Controller;
 use app\models\CategoryModel;
 use app\models\TopicModel;
 use app\models\PostModel;
 use app\models\PostImgModel;
 use app\controllers\OurWebController;
 use app\models\OurWebModel;


 class ForumController  extends Controller{

    public function createCat(){
        OurWebController::loginBar_vaild();
        if(isset($_POST['cat_name'])&&isset($_POST['cat_description'])){
            $cat_name=$_POST['cat_name'];
            $cat_description=$_POST['cat_description'];
            $cat_image=null;
            if(!((new CategoryModel())->search_name( $cat_name))){
                if(isset($_POST['cat_image'])&&$_POST['cat_image']!=null){
                    $cat_image=APP_PATH.ltrim($_POST['cat_image'],'/');
                    $target_name=time().strrchr($_POST['cat_image'],'.');
                    $targetPath = APP_PATH."images/category/".$target_name;
                        if(rename($cat_image,$targetPath)) {
                            $cat_image="/images/category/$target_name";
                        }else{
                            $cat_image='';
                        }
                    }else{
                        $cat_image='';
                    }
            }
            $this->assign('result',(new CategoryModel())->create_cat($cat_name,$cat_description,$cat_image));
        }
        return $this->render();
    }

//category setting administrator only
    public function updateCat($cat_id=0){
        OurWebController::loginBar_vaild();
        $row=(new CategoryModel())->search($cat_id);
        if( !$row){
            header("Location:/forum/forum");
        }
        $this->assign('cat_name',$row['cat_name'] );
        $this->assign('cat_image',$row['cat_image']);
        $this->assign('cat_description',$row['cat_description']);
        if(isset($_POST['cat_description'])){
            $cat_description=$_POST['cat_description'];
            $sourse=null;
            if(isset($_POST['cat_image'])&&$_POST['cat_image']!=null){
                $sourse=APP_PATH.ltrim($_POST['cat_image'],'/');
                $target_name=time().strrchr($_POST['cat_image'],'.');
                $targetPath = APP_PATH."images/category/".$target_name;
                if(file_exists($sourse)&&$sourse!=$targetPath&&$this->isImage($sourse)&&rename( $sourse,$targetPath)) {
                        $sourse="/images/category/$target_name";
                        if(file_exists(APP_PATH.ltrim($row['cat_image'],'\\'))){
                            unlink(APP_PATH.ltrim($row['cat_image'],'\\'));
                        }
                }else{
                    $sourse=null;
                }
                
            }
           
            $this->assign('result',(new CategoryModel())->update_cat($cat_id,$cat_description,$sourse));
        }
        return $this->render();
    }


    public function deleteCat($cat_id=0){
        $row=(new CategoryModel())->search($cat_id);
        if ($row){
            if(file_exists(APP_PATH.ltrim($row['cat_image'],'/'))){
                unlink(APP_PATH.ltrim($row['cat_image'],'/'));
            }
            (new CategoryModel())->delete_cat($cat_id);
        }
        header("Location:/ourweb/index");
    }


    public function createTop($cat_id=0){
        OurWebController::loginBar_vaild();
        if(!isset($_SESSION['id'])){
            header("Location:/forum/category/".$cat_id);
        }else{
        $row = (new CategoryModel())->search($cat_id);
        if( !$row){
            header("Location:/ourweb/index");
        }
        $this->assign('cat_name',$row['cat_name']);
        if(isset($_POST['topic_subject'])&& isset($_POST['post_content'])&&$_POST['topic_subject']!=null&&$_POST['post_content']!=null){
            $topic_subject=$_POST['topic_subject'];
            $post_content=$_POST['post_content'];
            $this->assign('resultTop',(new TopicModel())->create_top($topic_subject,$cat_id,$_SESSION['id']));

            $sql="SELECT @@IDENTITY";
            $sth=Db::pdo()->prepare($sql);
            $sth->execute();
            $topic_id=($sth->fetch())['@@IDENTITY'];

            $dir_name=null;
            if(isset($_POST['img'])){
                $dir_name=microtime();
                $dir=APP_PATH."images/post/".$dir_name;
                if(mkdir($dir)){
                    $this->get_post_content_create_img($post_content,$_POST['img'],$dir_name);
                }else{
                    $dir_name=null;
                }
            }

            date_default_timezone_set("Asia/Taipei");
            $post_date=date("Y-m-d H:i:s");

            $this->assign('resultPost',(new PostModel())->create_post($post_content, $topic_id,$_SESSION['id'],$post_date,$dir_name));
            (new TopicModel())->update_top_time( $topic_id,$post_date);
        }
        $this->assign('cat_id',$cat_id);
        return $this->render();
    }
}


    public function updateTop($topic_cat=0,$topic_id=0){
        OurWebController::loginBar_vaild();
        $row=((new TopicModel())->search($topic_cat,$topic_id));
         if(!$row){
             header("Location:/ourwen/index");
         }
         $data=(new TopicModel())->get_top_first_post($topic_id);
         $this->assign('topic_cat',$topic_cat);
         $this->assign('topic_subject',$data['topic_subject']);
         $this->assign('post_content',$data['post_content']);
         
         if(isset($_POST['topic_subject'])&&isset($_POST['post_content'])){
             $topic_subject=$_POST['topic_subject'];
             $post_content=$_POST['post_content'];
             if($data['post_dir']!=null){
                 $post_img = (new PostImgModel())->get_post_img($data['post_dir']);
                 foreach($post_img as $post_img_row){
                    if(file_exists(APP_PATH.'images/post/'.$post_img_row['post_dir'].'/'.$post_img_row['post_img_name'])&&
                    strpos($post_content,$post_img_row['post_img_name'])=== false){
                    unlink(APP_PATH.'images/post/'.$post_img_row['post_dir'].'/'.$post_img_row['post_img_name']);
                    (new PostImgModel())->delete_post_img($post_img_row['post_img_id']);
                    }
                }
                if(isset($_POST['img'])){
                    $this->get_post_content_create_img($post_content,$_POST['img'],$data['post_dir']);
                }
             }else{
                if(isset($_POST['img']) ){ 
                    $dir_name=microtime();
                    $dir=APP_PATH."images/post/".$dir_name;
                        if(mkdir($dir)){
                          $this->get_post_content_create_img($post_content,$_POST['img'],$dir_name);
                        }else{
                            $dir_name=null;
                        }
                }
            }
            if(isset($dir_name)){
            $result=(new TopicModel())->update_top_first_post($topic_id,$data['post_id'],$topic_subject,$post_content,$dir_name);
            }else{
            $result=(new TopicModel())->update_top_first_post($topic_id,$data['post_id'],$topic_subject,$post_content,$data['post_dir']);   
            }
            $this->assign('result',$result);
         }
         
         return $this->render();
     }


     public function updatePost($cat_id=0,$post_topic=0,$post_id=0){
        $row=(new PostModel())->search($post_id,$post_topic);
        if($row){
            $this->assign('topic_subject',$row['topic_subject']);
            $this->assign('cat_id',$cat_id);
            $this->assign('post_topic',$post_topic);
            $this->assign('post_content',$row['post_content']);
            if(isset($_POST['post_content'])){
                $post_content=$_POST['post_content'];
                if($row['post_dir']!=null){
                    $post_img=(new PostImgModel())->get_post_img($row['post_dir']);
                    foreach ($post_img as $post_img_row) {
                        if(file_exists(APP_PATH.'images/post/'.$post_img_row['post_dir'].'/'.$post_img_row['post_img_name'])&&
                            strpos($post_content,$post_img_row['post_img_name'])=== false){
                            unlink(APP_PATH.'images/post/'.$post_img_row['post_dir'].'/'.$post_img_row['post_img_name']);
                            (new PostImgModel())->delete_post_img($post_img_row['post_img_id']);
                        }
                    }
                    if(isset($_POST['img']) ){
                        $this->get_post_content_create_img($post_content,$_POST['img'],$row['post_dir']);
                    }
                }else{
                    if(isset($_POST['img']) ){ 
                        $dir_name=microtime();
                        $dir=APP_PATH."images/post/".$dir_name;
                            if(mkdir($dir)){
                              $this->get_post_content_create_img($post_content,$_POST['img'],$dir_name);
                            }else{
                                $dir_name=null;
                            }
                    }
                }
                if(isset($dir_name)){
                $result=(new PostModel())->update_post($post_id,$post_content,$dir_name);
                }else{
                $result=(new PostModel())->update_post($post_id,$post_content,$row['post_dir']);
                }
                $this->assign('result',$result);
            }
            $this->render();
        }else{
            header("Location:/forum/category/$cat_id");
        }
    }


    public function deleteTop($topic_cat=0,$topic_id=0){

        if(((new TopicModel())->search($topic_cat,$topic_id))){
            $posts=(new PostModel())->get_post_dir_not_null($topic_id);
            foreach ($posts as  $row) {
                if(file_exists(APP_PATH.'images/post/'.$row['post_dir'])){
                    $post_img=(new PostImgModel())->get_post_img($row['post_dir']);
                    foreach ($post_img as $post_img_row) {
                        if(file_exists(APP_PATH.'images/post/'.$post_img_row['post_dir'].'/'.$post_img_row['post_img_name'])){
                            unlink(APP_PATH.'images/post/'.$post_img_row['post_dir'].'/'.$post_img_row['post_img_name']);
                        }
                        (new PostImgModel())->delete_post_img($post_img_row['post_img_id']);
                    }
                    rmdir(APP_PATH.'images/post/'.$row['post_dir']);
                }
            }
            (new TopicModel())->delete_top($topic_id);
        }
        header("Location:/forum/category/$topic_cat");
    }


    public function deletePost($cat_id=0,$post_topic=0,$post_id=0){
        $row=(new PostModel())->search($post_id,$post_topic);
        if($row){
            if($row['post_dir']!=null){
                if(file_exists(APP_PATH.'images/post/'.$row['post_dir'])){
                    $post_img=(new PostImgModel())->get_post_img($row['post_dir']);
                    foreach ($post_img as $post_img_row) {
                        if(file_exists(APP_PATH.'images/post/'.$post_img_row['post_dir'].'/'.$post_img_row['post_img_name'])){
                            unlink(APP_PATH.'images/post/'.$post_img_row['post_dir'].'/'.$post_img_row['post_img_name']);
                        }
                        (new PostImgModel())->delete_post_img($post_img_row['post_img_id']);
                    }
                    rmdir(APP_PATH.'images/post/'.$row['post_dir']);
                }
            }

            (new PostModel())->delete_post($post_id);

        }
        header("Location:/forum/topic/$cat_id/$post_topic");
    }


    public function category($cat_id=0){
            OurWebController::loginBar_vaild();
            $row=((new CategoryModel())->search($cat_id));
            if( !$row){
                header("Location:/ourweb/index");
            }

            $this->assign('cat_name',$row['cat_name']);
            $this->assign('tops',(new TopicModel())->get_top($cat_id));
            $this->assign('cat_id',$cat_id); 

            return $this->render();
    }


    public function topic($topic_cat=0,$topic_id=0,$page=0){
        OurWebController::loginBar_vaild();
            $row = (new TopicModel())->search($topic_cat,$topic_id);
            if(!$row){
                header("Location:/ourweb/index");
            }
            if(isset($_POST['post_content']) &&isset($_SESSION['id'])){
                $dir_name=null;
                $post_content=$_POST['post_content'];
                if(isset($_POST['img']) && ($_POST['originator']==$_SESSION['record'])){ 
                    $dir_name=microtime();
                    $dir=APP_PATH."images/post/".$dir_name;
                    if(mkdir($dir)){
                        $this->get_post_content_create_img($post_content,$_POST['img'],$dir_name);
                    }else{
                     $dir_name=null;
                    }
                }
                
                date_default_timezone_set("Asia/Taipei");
                $post_date=date("Y-m-d H:i:s");
                if(isset($_POST['originator'])){
                    if($_POST['originator'] == $_SESSION['record']){
                        $this->assign('result',(new PostModel())->create_post($post_content,$topic_id,$_SESSION['id'],$post_date,$dir_name));
                        (new TopicModel())->update_top_time( $topic_id,$post_date);
                        $this->assign('flag',FALSE);
                    }else{
                        $this->assign('flag',TRUE);
                    }
                }
            }
            
            $this->assign('topic_subject',$row['topic_subject']);
            $this->assign('posts',(new PostModel())->get_post($topic_id));
            $this->assign('topic_cat',$topic_cat);
            $this->assign('topic_id',$topic_id);
            return $this->render();
    }


    public function uploadImage(){
        if(is_array($_FILES)) {    
            $image_path=array();
            if(is_uploaded_file($_FILES['cat_image']['tmp_name'])) {
                $sourcePath = $_FILES['cat_image']['tmp_name'];
                $targetPath = "./images/temp/".$_FILES['cat_image']['name'];
            
                if($this->isImage($sourcePath)){
                    if(move_uploaded_file($sourcePath,$targetPath)) {
                        $image_path=array('image_path'=>str_replace('/','\\',ltrim($targetPath,'.')));
                    }
                }else{
                     $image_path=array('error'=>$sourcePath);
                }
               
           
                   
            } 
            echo json_encode($image_path);
            
        }
    }


    public function uploadPostImage(){
        if(is_array($_FILES)) {  
            
            
            $file_count=count($_FILES['post_image']['tmp_name']);
            $image_path=array();
            for($i=0;$i<$file_count;$i++){
           
                if(is_uploaded_file($_FILES['post_image']['tmp_name'][$i])) {
                    $sourcePath = $_FILES['post_image']['tmp_name'][$i];
                    $targetPath = "./images/tempPost/".microtime().strrchr($_FILES['post_image']['name'][$i],'.');
                
                    if(true){//$this->isImage($sourcePath)
                        if(move_uploaded_file($sourcePath,$targetPath)) {
                            $image_path[$i]=ltrim($targetPath,'.');
                        }
                    }else{
                        $image_path[$i]=$sourcePath;
                    }
                }
            }
            echo json_encode($image_path);
        }
    }


    public function isImage($filename){
        $mimetype = exif_imagetype($filename);
        if ($mimetype == IMAGETYPE_GIF || $mimetype == IMAGETYPE_JPEG || $mimetype == IMAGETYPE_PNG )
        {
           return true;
        }else{
           return false;
        }
     }
     public function get_post_content_create_img(&$post_content,$post_img_array,$dir_name){
        $post_model=new PostImgModel();
        $dir=APP_PATH."images/post/".$dir_name;
        foreach ($post_img_array as  $value) {
                $img_path=APP_PATH.ltrim($value,'/');
                if(file_exists($img_path)&& strpos($post_content,$value)!== false){
                    $target_name=microtime().strrchr(strrchr($value,'/'),'.');
                    $targetPath =$dir.'/'.$target_name;
                        if(rename($img_path,$targetPath)) {
                            $target_image="/images/post/$dir_name/$target_name";
                            $post_content=str_replace($value, $target_image ,$post_content);
                            $post_model->create_post_img($dir_name,$target_name);
                        }
            }

        }
    }
}



?>
<?php
 namespace app\controllers;
 use fastphp\base\Controller;
 use app\models\OurWebModel;
 use app\models\CategoryModel;
 use app\models\TopicModel;
 use app\models\PostModel;

    class OurWebController  extends Controller{

        public function index(){
           $this->loginBar_vaild();
           $this->assign('cats',(new CategoryModel())->get_all_first_topic());
           return $this->render();
        }


        public function loginBar(){
            return $this->render();
        }


        public function register(){
            $valid = null;
            $msg='';
            if(isset($_POST['userN'])&&isset($_POST['pas1'])&&isset($_POST['pas2'])
            &&isset($_POST['mail'])&&isset($_POST['nickN'])){
                $regist_account = $_POST['userN'];
                $regist_password = $_POST['pas1'];
                $regist_nickname = $_POST['nickN'];
                $regist_mail = $_POST['mail'];
                $valid = (new OurWebModel())->log_up($regist_account,$regist_nickname,
                $regist_password,$regist_mail);

                if($valid){
                    header("Location:/ourweb/index");
                } else {
                    $msg='已存在的帳戶名稱!!';
                }
                
            }
            $this->loginBar_vaild($valid);
            $this->assign('msg',$msg);
            return $this->render();
        }

        public static function loginBar_vaild($valid=null){
            
            if(isset($_COOKIE['session_id'])){
                session_id($_COOKIE['session_id']);
            }
            session_start();
            $_SESSION['message']= '';
    
            if(isset($_POST['account']) && isset($_POST['password'])){
                $account=$_POST['account'];
                $password=$_POST['password'];
                $row=(new OurWebModel())->log_in($account, $password);
    
                if($account=='' || $password==''){
                    $_SESSION['message']="帳號或密碼不能為空";
                }else{
                    if ($row==false) {
                        $_SESSION['message']="帳號或密碼錯誤";
                    }else { 
                         
                            $cookieexpiry=(time()+21600);
                            setcookie('session_id',session_id(),$cookieexpiry);
                            $_COOKIE['session_id']=session_id();
                                    
                            $_SESSION['account'] = $row['ACCOUNT'];
                            $_SESSION['password'] = $row['PASSWORD'];
                            $_SESSION['nickname'] = $row['NICKNAME'];
                            $_SESSION['level'] = $row['level'];
                            $_SESSION['id'] = $row['ID'];
                    }
                }
              
            }
    
            if($valid){
                $row=(new OurWebModel())->log_in($_POST['userN'], $_POST['pas1']);
                $cookieexpiry=(time()+21600);
                setcookie('session_id',session_id(),$cookieexpiry);
                $_COOKIE['session_id']=session_id();
                        
                $_SESSION['account'] = $row['ACCOUNT'];
                $_SESSION['password'] = $row['PASSWORD'];
                $_SESSION['nickname'] = $row['NICKNAME'];
                $_SESSION['level'] = $row['level'];
                $_SESSION['id'] = $row['ID'];
            }
            if(isset($_POST['logout'])){
                header('Location:/ourweb/index');
                setcookie('session_id','',time()-21600);
                session_destroy();
                unset($_SESSION);
                unset($_COOKIE);
            }
        }

    }
 
?>
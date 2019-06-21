<?php
 namespace app\controllers;
 use fastphp\db\Db;
 use fastphp\base\Controller;
 use app\models\OurWebModel;
 use app\models\CategoryModel;
 use app\models\TopicModel;
 use app\models\PostModel;
 use app\controllers\OurWebController;

    class CompilerController  extends Controller{
        public function java(){
            OurWebController::loginBar_vaild();
            if(isset($_SESSION['id'])){
            if(isset($_POST["submitJava"])&& isset($_POST["java"])){
   
                $code=$_POST["java"];    
                $file=fopen("D:\\Xampp\\htdocs\\ourweb\\static\\java\\Main.java","w");
                fwrite($file,$code); 
                $Eresult='';

                exec("javac  D:\\Xampp\\htdocs\\ourweb\\static\\java\\Main.java 2>&1",$out);
            
                foreach ($out as $value) {
                    $Eresult.="<pre>".$value."<br></pre>";
                }
                if($out==NULL){
                $descriptor=array(0=>array("pipe","r"),
                1=>array("pipe","w"),
                2=>array("file","D:\\Xampp\\htdocs\\ourweb\\static\\java\\error.txt","w")
                );
            
                $process =proc_open("java -cp  D:\\Xampp\\htdocs\\ourweb\\static\\java; Main",$descriptor,$pipes);
               
            
            
                if(isset($_POST['stdin'])){
                    $str=$_POST['stdin'];
                //  $arr = explode("\n",$str);
                //    foreach ($arr as $value) {
                        fwrite($pipes[0],$str);
                //   }
            
                fclose($pipes[0]);
                }
                
                $errorF=fopen("./static/java/error.txt","r") or die("Unable to open file!");
                $Eresult="<pre style='margin:0;'>".stream_get_contents($pipes[1]).stream_get_contents($errorF)."</pre>";
                $this->assign('Eresult',$Eresult);
                fclose($pipes[1]);
            
                fclose($errorF);
                $return_value=proc_close($process);
               }
                fclose($file);
            }

            if(isset($_POST['stdin'])){
                $this->assign('stdin',$_POST['stdin']);
            }
            if(isset($_POST['java'])){
                $this->assign('java',$_POST['java']);
            }else{
                $str = "public class Main {
        
                    public static void main(String[] args) {
                        // TODO Auto-generated method stub
                            System.out.println(\"Hello world\");
                    
                    }
                
                }";
                $this->assign('java',$str);
            }
        }
        else{
            header('Location:/ourweb/index');
        }
            return $this->render();
        }
        public function web(){
            OurWebController::loginBar_vaild();
            if(!isset($_SESSION['id'])){
                header('Location:/ourweb/index');
            }
            return $this->render();
        }
    }
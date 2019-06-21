<?php
namespace app\models;

use fastphp\base\Model;
use fastphp\db\Db;

     class OurWebModel extends Model {
            protected $table='member';
            
            public function log_in($account=null,$password=null){
                if(($account!=null) && $password!=null){
                    
                    $this->where(["account=:account","and password=MD5(:password)"],
                                [":account"=>$account,":password"=>$password]);

                    return $this->fetch();
                }
            }   
            public function log_up($regist_account=null,
            $regist_nickname=null,$regist_password=null,
            $regist_GUID=null){

            if(($regist_account!=null) && ($regist_nickname!=null) && ($regist_password!=null) && ($regist_GUID!=null)){
                    $data['account'] = $regist_account;
                    $data['password'] = md5($regist_password);
                    $data['nickname'] = $regist_nickname;
                    $data['GUID'] = $regist_GUID;
                    $data['level'] = "member";
                    $result = $this->add($data);
                     return $result;
                }
            }
     }
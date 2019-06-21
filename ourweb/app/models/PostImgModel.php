<?php
namespace app\models;

use fastphp\base\Model;
use fastphp\db\Db;

    class PostImgModel extends Model {
        protected $table='post_img';
        protected $primary='post_img_id';
        public function create_post_img($post_dir,$post_img_name){
            $data['post_dir']=$post_dir;
            $data['post_img_name']=$post_img_name;
            $result=$this->add($data);
            return $result;
        }
        public function get_post_img($post_dir){
            return $this->where([' post_dir=:post_dir '],[':post_dir'=>$post_dir])->fetchAll();
        }
        public function delete_post_img($post_img_id){
            return $this->delete($post_img_id);
        }

    }
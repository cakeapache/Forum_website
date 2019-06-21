<?php
namespace app\models;

use fastphp\base\Model;
use fastphp\db\Db;
    class PostModel extends Model{
        protected $table='posts';
        protected $primary='post_id';

        public function create_post($post_content,$post_topic,$post_by,$post_date,$post_dir=null){
            $data['post_content']=$post_content;
            $data['post_topic']=$post_topic;
            $data['post_dir']=$post_dir;
            $data['post_by']=$post_by;
            $data['post_date']=$post_date;
            $result=$this->add($data);
            return $result;
    }
    public function update_post($post_id,$post_content,$post_dir=null){
        $data['post_content']=$post_content;
        $data['post_dir']=$post_dir;
        return $this->where(['post_id=:post_id'],['post_id'=>$post_id])->update($data);
    }
        public function get_post_dir_not_null($post_topic){
            return $this->where([' post_topic=:post_topic ',' and post_dir is not null '],[':post_topic'=>$post_topic])->fetchAll();
        } 
        public function get_post($post_topic){

            return $this->leftJoin('member','member.id=posts.post_by')->where(['posts.post_topic=:post_topic'],[':post_topic'=>$post_topic])->order(['posts.post_date '])->fetchAll();

        }
        public function delete_post($post_id){
            return $this->delete($post_id);
        }
        public function search($post_id,$post_topic){
            $sql='select topics.topic_subject ,posts.post_id, posts.post_content ,posts.post_dir ';
            $sql.='from topics left join posts on topics.topic_id=posts.post_topic ';
            $sql.='where topics.topic_id= :post_topic and posts.post_id=:post_id ';
            $sql.='order by posts.post_date';
            $sth=Db::pdo()->prepare($sql);
            $sth=$this->formatParam($sth,[':post_topic'=>$post_topic,
                                          ':post_id'=>$post_id]);
            $sth->execute();
            return  $sth->fetch();
        }
    }

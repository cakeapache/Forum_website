<?php
namespace app\models;

use fastphp\base\Model;
use fastphp\db\Db;
    class CategoryModel extends Model{
        protected $table="categories";
        protected $primary='cat_id';

        public function create_cat( $cat_name, $cat_description, $cat_image=null){
            $data["cat_name"]= $cat_name;
            $data["cat_description"]=$cat_description;
            $data["cat_image"]=$cat_image;
            $result=$this->add($data);
            return $result;
        }
        public function get_all_first_topic(){
            $sql ="select  categories.*,topics.* from categories   ";
            $sql.="left join (select * from (topics ,(select max(topic_date)as max_date from topics group by topic_cat) as max_topic) where max_topic.max_date=topic_date) as topics ";
            $sql.="on topics.topic_cat=categories.cat_id ";
            $sql.="order by categories.cat_id ";
            $sth=Db::pdo()->prepare($sql);
            $sth->execute();
            return $sth->fetchAll();
        }
        public function get_all_cat(){
            return $this->fetchAll();
        }
        public function update_cat($cat_id,$cat_description,$cat_image){
            $data['cat_description']=$cat_description;
            $data['cat_image']=$cat_image;
            $result=$this->where(['cat_id=:cat_id'],[':cat_id'=>$cat_id])->update($data);
            return $result;
        }
        public function delete_cat($cat_id){
            return $this->delete($cat_id);
        }
        public function search($cat_id){
            $result=$this->where(['cat_id=:cat_id'],[':cat_id'=>$cat_id]);
            return $result->fetch();
        }
        public function search_name($cat_name){
            $result=$this->where(['cat_name=:cat_name'],[':cat_name'=>$cat_name]);
            return $result->fetch();
        }
    }

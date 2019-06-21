<?php
namespace app\models;

use fastphp\base\Model;
use fastphp\db\Db;

class TopicModel extends Model{
    protected $table="topics";
    protected $primary='topic_id';
//建立topic
    public function create_top( $topic_subject, $topic_cat,$topic_by){
        $data["topic_subject"]= $topic_subject;
        $data['topic_cat']= $topic_cat;
        $data["topic_by"]= $topic_by;
        $result=$this->add($data);
        return $result;
    }

//取得最新的topic
public function get_top_first_post($topic_id){
    $sql='select topics.topic_subject ,posts.* ';
    $sql.='from topics left join posts on topics.topic_id=posts.post_topic ';
    $sql.='where topics.topic_id= :topic_id ';
    $sql.='order by posts.post_date';
    $sth=Db::pdo()->prepare($sql);
    $sth=$this->formatParam($sth,[':topic_id'=>$topic_id]);
    $sth->execute();

    return  $sth->fetch();
}   

//建立topic的第一個post
public function update_top_first_post($topic_id,$post_id,$topic_subject,$post_content,$post_dir){
    $sql='update topics left join posts  ';
    $sql.='on topics.topic_id=posts.post_topic ';
    $sql.='set topics.topic_subject=:topic_subject , posts.post_content=:post_content , posts.post_dir=:post_dir '; 
    $sql.='where topics.topic_id=:topic_id and posts.post_id=:post_id ';
    $sth=Db::pdo()->prepare($sql);
    $sth=$this->formatParam($sth,[':topic_subject'=>$topic_subject,
                                  ':post_content'=>$post_content,
                                  ':topic_id'=>$topic_id,
                                  ':post_id'=>$post_id,
                                  ':post_dir'=>$post_dir]);
    $sth->execute();
    return $sth->rowCount();
}

//列出所有topics
public function get_top($topic_cat){
    $sql="select topics.* ,member.ACCOUNT ,member.NICKNAME,member.level, post_cont.post_content ";
    $sql.="from topics left join member  on topics.topic_by=member.ID ";
    $sql.="left join  ";
    $sql.="(select posts.post_content ,posts.post_topic,min(posts.post_date)as minum ";
    $sql.="from posts group by posts.post_topic  )as post_cont ";
    $sql.="on post_cont.post_topic=topics.topic_id ";
    $sql.="  where topics.topic_cat=:topic_cat ";
    $sql.="order by topics.topic_date desc ";
    $sth=Db::pdo()->prepare($sql);
    $sth=$this->formatParam($sth,[':topic_cat'=>$topic_cat]);
    $sth->execute();
    return $sth->fetchAll();
}
    public function get_first_top($topic_cat){
        return $this->where(['topic_cat=:topic_cat'],[':topic_cat'=>$topic_cat])->order(['topic_date DESC'])->fetch();
    }

//更新topic時間為其下最新post
    public function update_top_time($topic_id,$topic_date){
        $data['topic_date']=$topic_date;
        return $this->where([' topic_id=:topic_id'],[':topic_id'=>$topic_id])->update($data);
    }


    public function update_top($topic_cat,$topic_id,$topic_subject){
        $data['topic_subject']=$topic_subject;
        return $this->where(['topic_cat=:topic_cat','and topic_id=:topic_id'],[':topic_cat'=>$topic_cat,':topic_id'=>$topic_id])->update($data);
    }


    public function delete_top($topic_id){
        return $this->delete($topic_id);
    }


    public function search($topic_cat,$topic_id){
        $result=$this->where(['topic_id=:topic_id','and topic_cat=:topic_cat'],[':topic_id'=>$topic_id,':topic_cat'=>$topic_cat]);
        return $result->fetch();
    }
}

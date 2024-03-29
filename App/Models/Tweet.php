<?php

    namespace App\Models;

    use MF\Model\Model;

    class Tweet extends Model {

        private $id;
        private $user_id;
        private $tweet;
        private $date;

        public function __get($attribute) {
            return $this->$attribute;
        }

        public function __set($attribute, $value) {
            $this->$attribute = $value;
        }

        // Save Tweet
        public function save() {
            $query = 'insert into tweets (user_id,
                                          tweet)
                                 values (:user_id,
                                         :tweet)';

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':user_id', $this->__get('user_id'));
            $stmt->bindValue(':tweet', $this->__get('tweet'));

            $stmt->execute();

            return $this;
        }

        // Remove Tweet
        public function remove() {
            $query = 'delete from tweets
                            where id = :id';
                      
            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':id', $this->__get('id'));

            $stmt->execute();

            return true;
        }

        // Get tweets with pagination
        public function getPerPage($limit, $offset) {
            $query = "select t.id, 
                             u.name, 
                             t.user_id,
                             t.tweet, 
                             DATE_FORMAT(t.date, '%d/%m/%y %H:%i') date
                        from tweets t left join users u
                          on t.user_id = u.id
                       where t.user_id = :user_id
                          or t.user_id in (select uf.user_id_follow  
                                             from usersfollowers uf
                                            where uf.user_id = :user_id)
                    order by t.date desc
                       limit $limit
                      offset $offset";
            
            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':user_id', $this->__get('user_id'));

            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        }
    }
?>
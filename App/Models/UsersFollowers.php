<?php

    namespace App\Models;

    use MF\Model\Model;

    class UsersFollowers extends Model {
    
        private $id;
        private $user_id;
        private $user_id_follow;

        public function __get($attribute) {
            return $this->$attribute;
        }

        public function __set($attribute, $value) {
            $this->$attribute = $value;
        }

        public function followUser() {
            $query = 'insert into usersfollowers
                                  (user_id,
                                  user_id_follow)
                           values (:user_id,
                                  :user_id_follow)';

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':user_id', $this->__get('user_id'));
            $stmt->bindValue(':user_id_follow', $this->__get('user_id_follow'));

            $stmt->execute();

            return true;
        }

        public function unfollowUser() {
            $query = 'delete from usersfollowers
                            where user_id = :user_id
                              and user_id_follow = :user_id_follow';

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':user_id', $this->__get('user_id'));
            $stmt->bindValue(':user_id_follow', $this->__get('user_id_follow'));

            $stmt->execute();

            return true;
        }
    }

?>

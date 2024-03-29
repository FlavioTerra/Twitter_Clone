<?php

    namespace App\Models;

    use MF\Model\Model;

    class User extends Model{

        private $id;
        private $name;
        private $email;
        private $password;

        public function __get($attribute) {
            return $this->$attribute;
        }

        public function __set($attribute, $value) {
            $this->$attribute = $value;
        }

        // Save User
        public function save() {
            $query = 'insert into users (name,
                                         email,
                                         password)
                                 values (:name,
                                         :email,
                                         :password)';

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':name', $this->__get('name'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':password', $this->__get('password')); 

            $stmt->execute();

            return $this;
        }

        // Retrive a user by email for validation 
        public function getUserByEmail() {
            $query = 'select name,
                             email
                        from users
                       where email = :email';

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':email', $this->__get('email'));

            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_OBJ);            
        }

        // Valid if registration can be performed
        public function validateRegistration() {
            $valid = true;

            if(strlen($this->__get('name')) < 3) {
                $valid = false;
            
            } else if(strlen($this->__get('email')) < 3) {
                $valid = false;

            } else if(strlen($this->__get('password')) < 3) {
                $valid = false;

            }

            return $valid;
        }

        // Valid if the user is registered for authentication
        public function authenticate() {
            $query = 'select id,
                             name,
                             email
                        from users
                       where email = :email
                         and password = :password';
            
            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':password', $this->__get('password'));

            $stmt->execute();

            $user = $stmt->fetch(\PDO::FETCH_OBJ);  
            
            if($user) {
                $this->__set('id', $user->id);
                $this->__set('name', $user->name);  
            }

            return $this;  
        }

        public function getAll() {
            $query = 'select u.id,
                             u.name,
                             u.email,
                             (select count(*)
                                from usersfollowers uf
                               where uf.user_id = :id
                                 and uf.user_id_follow = u.id
                             ) following_yn
                        from users u    
                       where u.name like :name
                         and u.id <> :id';
            
            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':name', '%' . $this->__get('name') . '%');
            $stmt->bindValue(':id', $this->__get('id'));

            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        }

        public function countAllTweets() {
            $query = "select count(*) as total_tweets,
                             (select count(*) 
                                from tweets tw
                               where tw.user_id = :id
                             ) as total_tweets_user
                        from tweets t left join users u
                          on t.user_id = u.id
                       where t.user_id = :id
                          or t.user_id in (select uf.user_id_follow  
                                             from usersfollowers uf
                                            where uf.user_id = :id)";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':id', $this->__get('id'));

            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_OBJ);
        }

        public function countAllFollowing() {
            $query = 'select count(*) total_following from usersfollowers where user_id = :id';

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':id', $this->__get('id'));

            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_OBJ);
        }

        public function countAllFollowers() {
            $query = 'select count(*) total_followers from usersfollowers where user_id_follow = :id';

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':id', $this->__get('id'));

            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_OBJ);
        }

    }
?>
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

        // Save
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
            $stmt->bindValue(':password', $this->__get('password')); // md5() cryptography hash 32 caracters

            $stmt->execute();

            return $this;
        }

        // Retrive a user by email
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
    }

?>
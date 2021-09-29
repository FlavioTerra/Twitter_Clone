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

        // Retrive a user by email
        public function getUserByEmail() {
            
        }
    }

?>
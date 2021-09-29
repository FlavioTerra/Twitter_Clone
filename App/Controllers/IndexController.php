<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class IndexController extends Action {

        public function index() {

            $this->render('index');
        }

        public function inscreverse() {

            $this->render('inscreverse');
        }

        public function registrar() {

            // Receive form data
            $user = Container::getModel('user');

            $user->__set('name', $_POST['name']);
            $user->__set('email', $_POST['email']);
            $user->__set('password', $_POST['password']);

            // Sucess
            if($user->validateRegistration()) {
                $user->save();
            
            // Error
            } else {
                // ...
            }
        }
    }   

?>
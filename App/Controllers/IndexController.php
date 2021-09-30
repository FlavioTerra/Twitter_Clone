<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class IndexController extends Action {

        public function index() {   

            $this->render('index');
        }

        public function inscreverse() {

            $this->view->erroCadastro = false;

            $this->view->user = array(
                'name' => '',
                'email' => '',
                'password' => ''
            );

            $this->render('inscreverse');
        }

        public function registrar() {

            // Receive form data
            $user = Container::getModel('user');

            $user->__set('name', $_POST['name']);
            $user->__set('email', $_POST['email']);
            $user->__set('password', $_POST['password']);

            // Sucess
            if($user->validateRegistration() && count($user->getUserByEmail()) == 0) {
                $user->save();
                $this->render('cadastro');   

            // Error
            } else {
                $this->view->erroCadastro = true;

                $this->view->user = array(
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'password' => $_POST['password']
                );

                $this->render('inscreverse');
            }
        }
    }   

?>
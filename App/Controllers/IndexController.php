<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class IndexController extends Action {

        public function index() {   

            $this->view->login = isset($_GET['login']) ? $_GET['login'] : '';

            $this->render('index');
        }

        public function inscreverse() {

            $this->view->errorReg = false;

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
            $user->__set('password', md5($_POST['password']));

            // Success
            if($user->validateRegistration() && count($user->getUserByEmail()) == 0) {
                $user->save();
                $this->render('cadastro');   

            // Error
            } else {
                $this->view->errorReg = true;

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
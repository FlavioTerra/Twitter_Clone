<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class AuthController extends Action {

        public function autenticar() {

            $user = Container::getModel('user');

            $user->__set('email', $_POST['email']);
            $user->__set('password', md5($_POST['password']));

            $user->authenticate();

            if(!empty($user->__get('id')) && !empty($user->__get('name'))) {
                
                session_start(); 
                
                $_SESSION['id'] = $user->__get('id');
                $_SESSION['name'] = $user->__get('name');

                header('Location: /timeline');
                
                echo 'Autenticado';
            } else {
                header('Location: /?login=error');
            }
        }

        public function sair() {
            session_start();
            session_destroy();
            header('Location: /');
        }
    }

?>
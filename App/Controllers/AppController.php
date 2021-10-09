<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class AppController extends Action {
        
        public function timeline() {

            session_start();
            
            if(isset($_SESSION['id']) && isset($_SESSION['name'])){
                $this->render('timeline');
            } else {
                header('Location: /?login=error');
            }
        }

        public function tweet() {
            
            session_start();
            
            if(isset($_SESSION['id']) && isset($_SESSION['name'])){
                
                $tweet = Container::getModel('tweet');
                
                $tweet->__set('user_id', $_SESSION['id']);
                $tweet->__set('tweet', $_POST['tweet']);

                $tweet->save();

            } else {
                header('Location: /?login=error');
            }  

        }
    }

?>

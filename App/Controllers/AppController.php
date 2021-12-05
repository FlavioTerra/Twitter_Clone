<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class AppController extends Action {
        
        public function timeline() {

            $this->validAuthentication();

            $tweet = Container::getModel('tweet');

            $tweet->__set('user_id', $_SESSION['id']);

            $this->view->tweets = $tweet->getAll();

            $this->getInfoUser();

            $this->render('timeline');
        }

        public function tweet() {
            
            $this->validAuthentication();
                
            $tweet = Container::getModel('tweet');
            
            $tweet->__set('user_id', $_SESSION['id']);
            $tweet->__set('tweet', $_POST['tweet']);

            $tweet->save();

            header('Location: /timeline');
        }

        public function removeTweet() {

            $this->validAuthentication();

            $tweet = Container::getModel('tweet');

            $tweet->__set('id', $_GET['removeTweet']);

            $tweet->remove();

            header('Location: /timeline');
        }

        public function quemSeguir() {

            $this->validAuthentication();

            $searchUser = isset($_GET['searchFor']) ? $_GET['searchFor'] : '';

            $this->view->users = array();

            if(!empty($searchUser)) {
                $users = Container::getModel('user');

                $users->__set('name', $searchUser);
                $users->__set('id', $_SESSION['id']);

                $this->view->users = $users->getAll();
            }

            $this->getInfoUser();

            $this->render('quemSeguir');
        }

        public function acao() {

            $this->validAuthentication();

            $action = isset($_GET['action']) ? $_GET['action'] : '';
            $userIdFollow = isset($_GET['userId']) ? $_GET['userId'] : '';

            $usersFollowers = Container::getModel('usersFollowers');
            
            $usersFollowers->__set('user_id', $_SESSION['id']);
            $usersFollowers->__set('user_id_follow', $userIdFollow);

            if($action == 'follow') {
                $usersFollowers->followUser();
            } else if($action == 'unfollow') {
                $usersFollowers->unfollowUser();
            }

            header('Location: /quemSeguir');
        }

        public function getInfoUser() {
            $infosUser = Container::getModel('user');

            $infosUser->__set('id', $_SESSION['id']);

            $this->view->allTweetsUser = $infosUser->countAllTweetsUser();
            $this->view->allFollowing = $infosUser->countAllFollowing();
            $this->view->allFollowers = $infosUser->countAllFollowers();
        }
        
        public function validAuthentication() {

            session_start();

            if(!isset($_SESSION['id']) && !isset($_SESSION['name'])) {
                header('Location: /?login=error');
            }
        }
    }

?>

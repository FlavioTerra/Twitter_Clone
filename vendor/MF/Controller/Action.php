<?php

    namespace MF\Controller;

    abstract class Action {

        protected $view;

        public function __construct() {
            $this->view = new \stdClass();
        }

        protected function render($view, $layout) {
            
            $this->view->page = $view;

            if(file_exists("../App/Views/" . $layout . ".phtml")) {
                require_once "../App/Views/" . $layout . ".phtml";
            } else {
                $this->content();
            }
        }

        protected function content() {
            $currentClass = get_class($this);
            $currentClass = explode('\\', $currentClass);
            $folderPath = strtolower(str_replace('Controller', '', $currentClass[2]));

            require_once "../App/Views/" . $folderPath . "/" . $this->view->page . ".phtml";
        }
    }    

?>
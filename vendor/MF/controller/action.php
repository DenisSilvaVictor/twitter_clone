<?php 

    namespace MF\Controller;

    abstract class Action {
      
        protected $viewObj = null;

        public function __construct(){

            $this->viewObj = new \stdClass();
        }

        protected function render($view, $layout = 'layout') {

            $this->viewObj->page = $view;

            if(file_exists('../App/Views/' .$layout. '.phtml')){
                require_once '../App/Views/' .$layout. '.phtml';
            }else{
                require_once '../App/Views/layout.phtml';
            }
        }

        protected function content(){
            
            $classAtual = get_class($this);
            $classAtual = str_replace('App\\Controller\\', '', $classAtual);
            $controller = strtolower(str_replace('Controller', '', $classAtual));

            require_once '../App/views/'. $controller .'/'. $this->viewObj->page .'.phtml';
        }
    }


?>

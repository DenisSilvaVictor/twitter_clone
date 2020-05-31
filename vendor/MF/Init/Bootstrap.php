<?php 

    namespace MF\Init;

    /*
    classes,funções ou variaveis abstratras são elementos que não podem ser 
    instânciado, apenas herdados, e so depois de herdados são usados normalmente
    -------------------------*/

    
    abstract class Bootstrap {

        private $routes;

        abstract protected function initRoutes();

        public function __construct(){
            $this->initRoutes();
            $this->run($this->getUrl());
        }
        
        public function  getRoutes(){
            return $this->routes;
        }

        public function setRoutes(array $routes){
            $this->routes = $routes;
        }

        protected function run($url) {

            foreach($this->getRoutes() as $path => $route){

               if($url == $route['route']){
                    $class = 'App\\Controller\\' . $route['controller'];
                    
                    $controller = new $class;

                    $action = $route['action'];
                    
                    $controller->$action();
               }
            }
        }

        protected function getUrl(){
            return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        }
    }

?>
<?php 

    namespace App;

    //pegando class especifica
    use MF\Init\Bootstrap;

    class Route extends Bootstrap {

        protected function initRoutes(){

            $routes['home'] = array(
                'route' => '/',
                'controller' => 'IndexController',
                'action' => 'index'
            );

            $routes['inscreverse'] = array(
                'route' => '/inscreverse',
                'controller' => 'IndexController',
                'action' => 'inscreverse'
            );

            $routes['cadastrar'] = array(
                'route' => '/cadastrar',
                'controller' => 'IndexController',
                'action' => 'cadastrar'
            );

            $routes['logar'] = array(
                'route' => '/logar',
                'controller' => 'AuthController',
                'action' => 'logar'
            );
            
            $routes['deslogar'] = array(
                'route' => '/deslogar',
                'controller' => 'AuthController',
                'action' => 'deslogar'
            );

            $routes['timeline'] = array(
                'route' => '/timeline',
                'controller' => 'AppController',
                'action' => 'timeLine'
            );

            $routes['twittar'] = array(
                'route' => '/twittar',
                'controller' => 'AppController',
                'action' => 'twittar'
            );

            $routes['seguir'] = array(
                'route' => '/seguir',
                'controller' => 'AppController',
                'action' => 'seguir'
            );

            $routes['remover'] = array(
                'route' => '/remover',
                'controller' => 'AppController',
                'action' => 'remover'
            ); 

            $this->setRoutes($routes);
        }

    }


?>
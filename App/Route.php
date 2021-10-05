<?php

    namespace App;

    use MF\Init\Bootstrap;

    class Route extends Bootstrap{
        
        protected function initRoutes() {

            $routes['home'] = array(
                'route' => '/',
                'controller' => 'indexController',
                'action' => 'index'
            );

            $routes['inscreverse'] = array(
                'route' => '/inscreverse',
                'controller' => 'indexController',
                'action' => 'inscreverse'
            );

            $routes['registrar'] = array(
                'route' => '/registrar',
                'controller' => 'indexController',
                'action' => 'registrar'
            );

            $routes['autenticar'] = array(
                'route' => '/autenticar',
                'controller' => 'authController',
                'action' => 'autenticar'
            );

            $routes['timeline'] = array(
                'route' => '/timeline',
                'controller' => 'appController',
                'action' => 'timeline'
            );

            $routes['sair'] = array(
                'route' => '/sair',
                'controller' => 'authController',
                'action' => 'sair'
            );

            $this->setRoutes($routes);
        }    
    }

?>
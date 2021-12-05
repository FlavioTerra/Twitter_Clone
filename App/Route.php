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

            $routes['tweet'] = array(
                'route' => '/tweet',
                'controller' => 'appController',
                'action' => 'tweet'
            );

            $routes['removeTweet'] = array(
                'route' => '/removeTweet',
                'controller' => 'appController',
                'action' => 'removeTweet'
            );

            $routes['quemSeguir'] = array(
                'route' => '/quemSeguir',
                'controller' => 'appController',
                'action' => 'quemSeguir'
            );

            $routes['acao'] = array(
                'route' => '/acao',
                'controller' => 'appController',
                'action' => 'acao'
            );

            $this->setRoutes($routes);
        }    
    }

?>
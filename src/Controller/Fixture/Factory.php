<?php

namespace RudiBieller\OnkelRudi\Controller\Fixture;

use Slim\App;

class Factory
{
    public static function createSlimAppWithStandardTestContainer()
    {
        $config = \Mockery::mock('RudiBieller\OnkelRudi\Config\Config');
        $config->shouldReceive('getSystemConfiguration')->andReturn(array('environment' => 'dev'));

        $router = \Mockery::mock('Slim\Interfaces\RouterInterface');
        $router->shouldReceive('pathFor')->once()->andReturn('/foo/');

        $app = new App();
        $container = $app->getContainer();
        $container['view'] = function ($cArg) {
            $view = new \Slim\Views\Twig(
                dirname(__FILE__).'/../../../public/templates',
                ['cache' => false]
            );

            $view->addExtension(new \Slim\Views\TwigExtension(
                $cArg['router'],
                $cArg['request']->getUri()
            ));

            return $view;
        };
        $container['config'] = $config;
        $container['router'] = $router;

        return $app;
    }
    
    public static function createUserServiceWithAuthenticatedUserSession($returnUser = null)
    {
        $session = \Mockery::mock('Zend\Authentication\Storage\Session');
        $session->shouldReceive('read')->once()->andReturn($returnUser);
        $authService = \Mockery::mock('Zend\Authentication\AuthenticationService');
        $authService->shouldReceive('getStorage')->once()->andReturn($session);

        $userService = \Mockery::mock('RudiBieller\OnkelRudi\User\UserService');
        $userService->shouldReceive('getAuthenticationService')->andReturn($authService);

        return $userService;
    }

    public static function createTestRequest()
    {
        $uri = \Mockery::mock('Slim\Http\Uri');
        $uri->shouldReceive('getQuery')->andReturn('/foo/?test=1');

        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getUri')->andReturn($uri);

        return $request;
    }

    public static function createStandardResponse()
    {
        $body = \Mockery::mock('Slim\HttpBody');
        $body->shouldReceive('write');

        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->once()->andReturn($body)
            ->shouldReceive('write');

        return $response;
    }
}

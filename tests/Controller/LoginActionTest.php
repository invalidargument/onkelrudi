<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\Config\Config;
use Slim\App;
use Zend\Authentication\Storage\Session;

class LoginActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionReturnsRequestedMarket()
    {
        $router = \Mockery::mock('Slim\Interfaces\RouterInterface');
        $router->shouldReceive('pathFor')->once()->with('profile')->andReturn('/profil/');

        $app = new App();
        $container = $app->getContainer();
        $container['view'] = function ($c) {
            $view = new \Slim\Views\Twig(
                dirname(__FILE__).'/../../public/templates',
                [
                    //'cache' => 'templates/cache'
                    'cache' => false
                ]
            );

            $view->addExtension(new \Slim\Views\TwigExtension(
                $c['router'],
                $c['request']->getUri()
            ));

            return $view;
        };
        $container['router'] = $router;
        $container['config'] = new Config();
        $body = \Mockery::mock('Slim\HttpBody');
        $body->shouldReceive('write')
            ->shouldReceive('__toString')->andReturn('String representation of the Body object');
        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->once()->andReturn($body)
            ->shouldReceive('write');

        $authenticationService = \Mockery::mock('Zend\Authentication\AuthenticationService');
        $authenticationService->shouldReceive('getStorage')->once()->andReturn(new Session());

        $userService = \Mockery::mock('RudiBieller\OnkelRudi\User\UserService');
        $userService->shouldReceive('getAuthenticationService')->andReturn($authenticationService)
            ->shouldReceive('isLoggedIn')->andReturn(false);

        $wordpressService = \Mockery::mock('RudiBieller\OnkelRudi\Wordpress\ServiceInterface');
        $wordpressService->shouldReceive('getAllCategories')->andReturn([]);

        $action = new LoginAction();
        $action->setApp($app);
        $action->setWordpressService($wordpressService)
            ->setUserService($userService);

        $return = $action($request, $response, array('login_email' => 'foo@example.com', 'nonsense'));
        $actual = (string)$return->getBody();
        $expected = 'String representation of the Body object';

        $this->assertContains($expected, $actual);

        $this->assertAttributeEquals(
            ['loggedIn' => true, 'profileurl' => '/profil/'],
            'templateVariables',
            $action
        );
    }
}

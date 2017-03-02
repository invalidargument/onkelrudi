<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\Controller\Fixture\Factory;
use RudiBieller\OnkelRudi\User\Organizer;
use Slim\App;

class ChangePasswordActionTest extends \PHPUnit_Framework_TestCase
{
    private $_app;

    protected function setUp()
    {
        parent::setUp();

        $config = \Mockery::mock('RudiBieller\OnkelRudi\Config\Config');
        $config->shouldReceive('getSystemConfiguration')->andReturn(array('environment' => 'dev'));

        $router = \Mockery::mock('Slim\Interfaces\RouterInterface');
        $router->shouldReceive('pathFor')->once()->with('login-register')->andReturn('/login/')
            ->shouldReceive('pathFor')->once()->with('create-fleamarket')->andReturn('/flohmarkt-anlegen/')
            ->shouldReceive('pathFor')->once()->with('profile')->andReturn('/profil/')
            ->shouldReceive('pathFor')->once()->with('logout')->andReturn('/logout/');

        $this->_app = new App();
        $container = $this->_app->getContainer();
        $container['view'] = function ($c) {
            $view = new \Slim\Views\Twig(
                dirname(__FILE__).'/../../public/templates',
                ['cache' => false]
            );

            $view->addExtension(new \Slim\Views\TwigExtension(
                $c['router'],
                $c['request']->getUri()
            ));

            return $view;
        };
        $container['config'] = $config;
        $container['router'] = $router;
    }

    public function testActionSetsTemplateVariables()
    {
        $action = new ChangePasswordAction();
        $action->setApp($this->_app);

        $wordpressService = \Mockery::mock('RudiBieller\OnkelRudi\Wordpress\ServiceInterface');
        $wordpressService->shouldReceive('getAllCategories')->andReturn([]);

        $user = new Organizer('bar@example.com');
        $session = \Mockery::mock('Zend\Authentication\Storage\Session');
        $session->shouldReceive('read')->once()->andReturn($user);
        $authenticationService = \Mockery::mock('Zend\Authentication\AuthenticationService');
        $authenticationService->shouldReceive('getStorage')->once()->andReturn($session);
        $userService = \Mockery::mock('RudiBieller\OnkelRudi\User\UserService');
        $userService->shouldReceive('getAuthenticationService')->andReturn($authenticationService)
            ->shouldReceive('isLoggedIn')->andReturn(false);

        $action->setWordpressService($wordpressService)
            ->setUserService($userService);

        $request = Factory::createTestRequest();
        $response = Factory::createStandardResponse();
        $action($request, $response, array());

        $this->assertAttributeEquals(
            ['profileurl' => '/profil/', 'createfleamarketurl' => '/flohmarkt-anlegen/', 'logouturl' => '/logout/'],
            'templateVariables',
            $action
        );
    }
}

<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;
use Slim\App;
use Zend\Authentication\Storage\Session;

class EditFleaMarketActionTest extends \PHPUnit_Framework_TestCase
{
    private $_app;

    protected function setUp()
    {
        parent::setUp();

        $config = \Mockery::mock('RudiBieller\OnkelRudi\Config\Config');
        $config->shouldReceive('getSystemConfiguration')->andReturn(array('environment' => 'dev'));

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
    }

    public function testActionSetsNeededTemplateVariables()
    {
        $organizer = new Organizer();
        $organizer->setId(42);

        $fleamarket = new FleaMarket();
        $fleamarket->setId(23);
        $fleamarket->setOrganizer($organizer);

        $session = \Mockery::mock('Zend\Authentication\Storage\Session');
        $session->shouldReceive('read')->andReturn('my session is a fucking string');

        $uri = \Mockery::mock('Slim\Http\Uri');
        $uri->shouldReceive('getQuery')->andReturn('/foo/?test=1');

        $body = \Mockery::mock('Slim\HttpBody');
        $body->shouldReceive('write');

        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getUri')->andReturn($uri);
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->once()->andReturn($body)
            ->shouldReceive('write');

        $authenticationService = \Mockery::mock('Zend\Authentication\AuthenticationService');
        $authenticationService->shouldReceive('getStorage')->once()->andReturn($session);

        $userService = \Mockery::mock('RudiBieller\OnkelRudi\User\UserService');
        $userService->shouldReceive('getAuthenticationService')->andReturn($authenticationService)
            ->shouldReceive('isLoggedIn')->andReturn(true);

        $organizerService = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\OrganizerServiceInterface');
        $organizerService->shouldReceive('getOrganizer')->once()->with(42)->andReturn($organizer);

        $wordpressService = \Mockery::mock('RudiBieller\OnkelRudi\Wordpress\ServiceInterface');
        $wordpressService->shouldReceive('getAllCategories')->andReturn([]);

        $fleamarketService = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketServiceInterface');
        $fleamarketService->shouldReceive('getFleaMarket')->once()->with(23)->andReturn($fleamarket);

        $action = new EditFleaMarketAction();
        $action->setApp($this->_app);
        $action->setUserService($userService);
        $action->setWordpressService($wordpressService);
        $action->setService($fleamarketService);
        $action->setOrganizerService($organizerService);

        $action($request, $response, array('id' => 23));

        $this->assertAttributeEquals(
            ['isTest' => true, 'loggedIn' => true, 'fleamarket_organizers' => array(), 'editForm' => true, 'editDto' => $fleamarket, 'isOrganizer' => null],
            'templateVariables',
            $action
        );
    }
}

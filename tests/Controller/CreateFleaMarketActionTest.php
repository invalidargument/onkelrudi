<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\Controller\Fixture\Factory;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;
use Zend\Authentication\Storage\Session;

class CreateFleaMarketActionTest extends \PHPUnit_Framework_TestCase
{
    private $_app;

    protected function setUp()
    {
        parent::setUp();

        $this->_app = Factory::createSlimAppWithStandardTestContainer();
    }

    public function testActionDoesRecognizeEmptySession()
    {
        $this->_app->getContainer()['view'] = \Mockery::mock('Slim\Views\Twig');
        $this->_app->getContainer()['view']
            ->shouldReceive('render')
            ->once()
            ->with(
                \Hamcrest\Matchers::anObject(),
                'unauthorized.html',
                \Hamcrest\Matchers::nonEmptyArray()
            );
        
        $uri = \Mockery::mock('Slim\Http\Uri');
        $uri->shouldReceive('getQuery')->andReturn('/foo/?test=false');

        $body = \Mockery::mock('Slim\HttpBody');
        $body->shouldReceive('write');

        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getUri')->andReturn($uri);
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->once()->andReturn($body)
            ->shouldReceive('write');

        $session = \Mockery::mock('Zend\Authentication\Storage\Session');
        $session->shouldReceive('read')->once()->andReturn(null);
        $authenticationService = \Mockery::mock('Zend\Authentication\AuthenticationService');
        $authenticationService->shouldReceive('getStorage')->once()->andReturn($session);

        $userService = \Mockery::mock('RudiBieller\OnkelRudi\User\UserService');
        $userService->shouldReceive('getAuthenticationService')->andReturn($authenticationService);

        $wordpressService = \Mockery::mock('RudiBieller\OnkelRudi\Wordpress\ServiceInterface');
        $wordpressService->shouldReceive('getAllCategories')->andReturn([]);

        $action = new CreateFleaMarketAction();
        $action->setApp($this->_app);
        $action->setUserService($userService);
        $action->setWordpressService($wordpressService);

        $action($request, $response, array());

        $this->assertAttributeEquals(['profileurl' => '/foo/', 'createfleamarketurl' => '/foo/', 'changepasswordurl' => '/foo/', 'logouturl' => '/foo/'], 'templateVariables', $action);
    }

    public function testActionSetsNeededTemplateVariables()
    {
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
        $authenticationService->shouldReceive('getStorage')->once()->andReturn(new Session());

        $userService = \Mockery::mock('RudiBieller\OnkelRudi\User\UserService');
        $userService->shouldReceive('getAuthenticationService')->andReturn($authenticationService)
            ->shouldReceive('isLoggedIn')->andReturn(false);

        $wordpressService = \Mockery::mock('RudiBieller\OnkelRudi\Wordpress\ServiceInterface');
        $wordpressService->shouldReceive('getAllCategories')->andReturn([]);

        $organizer = new Organizer();
        $organizer->setId(23)->setName('foobarbaz');
        $organizers = array($organizer);

        $organizerService = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\OrganizerService');
        $organizerService->shouldReceive('getAllOrganizers')->once()->andReturn($organizers);

        $action = new CreateFleaMarketAction();
        $action->setApp($this->_app);
        $action->setUserService($userService);
        $action->setWordpressService($wordpressService);
        $action->setOrganizerService($organizerService);

        $action($request, $response, array());

        $this->assertAttributeEquals(
            ['isTest' => true, 'loggedIn' => true, 'fleamarket_organizers' => array(array('id' => 23, 'name' => 'foobarbaz')), 'createForm' => true, 'profileurl' => '/foo/', 'createfleamarketurl' => '/foo/', 'changepasswordurl' => '/foo/', 'logouturl' => '/foo/'],
            'templateVariables',
            $action
        );
    }
}

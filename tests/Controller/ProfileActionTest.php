<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\FleaMarket\Organizer;
use RudiBieller\OnkelRudi\User\Organizer as OrganizerUser;
use Slim\App;

class ProfileActionTest extends \PHPUnit_Framework_TestCase
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
            ->shouldReceive('pathFor')->once()->with('password')->andReturn('/passwort-aendern/')
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

    public function testActionShowsAuthenticationMessageWhenNotLoggedIn()
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

        $action = new ProfileAction();
        $action->setApp($this->_app);
        $action->setUserService($userService);
        $action->setWordpressService($wordpressService);

        $action($request, $response, array());

        $this->assertAttributeEquals(['profileurl' => '/profil/', 'createfleamarketurl' => '/flohmarkt-anlegen/', 'changepasswordurl' => '/passwort-aendern/', 'logouturl' => '/logout/'], 'templateVariables', $action);
    }

    /**
     * @dataProvider dataProviderTestActionSetsNeededTemplateVariables
     */
    public function testActionSetsNeededTemplateVariables($pageParameter, $pageProperty, $offset)
    {
        $user = new OrganizerUser('bar@example.com');

        $uri = \Mockery::mock('Slim\Http\Uri');
        $uri->shouldReceive('getQuery')->andReturn('/foo/?test=1');

        $body = \Mockery::mock('Slim\HttpBody');
        $body->shouldReceive('write');

        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getUri')->andReturn($uri);
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->once()->andReturn($body)
            ->shouldReceive('write');

        $session = \Mockery::mock('Zend\Authentication\Storage\Session');
        $session->shouldReceive('read')->once()->andReturn($user);
        $authenticationService = \Mockery::mock('Zend\Authentication\AuthenticationService');
        $authenticationService->shouldReceive('getStorage')->once()->andReturn($session);

        $userService = \Mockery::mock('RudiBieller\OnkelRudi\User\UserService');
        $userService->shouldReceive('getAuthenticationService')->andReturn($authenticationService)
            ->shouldReceive('isLoggedIn')->andReturn(false);

        $wordpressService = \Mockery::mock('RudiBieller\OnkelRudi\Wordpress\ServiceInterface');
        $wordpressService->shouldReceive('getAllCategories')->andReturn([]);

        $organizer = new Organizer();
        $organizer->setId(23)->setName('foobarbaz');
        $organizers = array($organizer);

        $organizerUser = new OrganizerUser();

        $organizerService = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\OrganizerService');
        $organizerService->shouldReceive('getAllOrganizers')->once()->andReturn($organizers)
            ->shouldReceive('getOrganizerByUserId')->once()->with('bar@example.com')->andReturn($organizerUser);

        $fleamarketService = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\FleaMarketServiceInterface');
        $fleamarketService->shouldReceive('getFleaMarketsByUser')->once()->with($user, 20, $offset)->andReturn([]);

        $action = new ProfileAction();
        $action->setApp($this->_app);
        $action->setService($fleamarketService);
        $action->setUserService($userService);
        $action->setWordpressService($wordpressService);
        $action->setOrganizerService($organizerService);

        $action($request, $response, array('page' => $pageParameter));

        $this->assertAttributeEquals(
            ['profileurl' => '/profil/', 'createfleamarketurl' => '/flohmarkt-anlegen/', 'fleamarkets' => [], 'organizer' => $organizerUser, 'page' => $pageProperty, 'logouturl' => '/logout/', 'changepasswordurl' => '/passwort-aendern/'],
            'templateVariables',
            $action
        );
        $this->assertAttributeEquals(
            $user,
            'result',
            $action
        );
    }

    public function dataProviderTestActionSetsNeededTemplateVariables()
    {
        return array(
            array(null, 0, 0),
            array(0, 0, 0),
            array(1, 1, 0),
            array(11, 11, 10),
            array(-1, 0, 0)
        );
    }
}

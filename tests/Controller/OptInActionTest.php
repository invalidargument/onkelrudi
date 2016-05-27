<?php

namespace RudiBieller\OnkelRudi\Controller;

use Slim\App;
use Zend\Authentication\Storage\Session;

class OptInActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProviderTestActionDoesOptInWhenGivenAValidToken
     */
    public function testActionDoesOptInWhenGivenAValidToken($serviceWasAbleToOptIn, array $expectedTemplateVariables)
    {
        $parsedJson = [
            'token' => '123abc456'
        ];

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
        $body = \Mockery::mock('Slim\HttpBody');
        $body->shouldReceive('write')
            ->shouldReceive('__toString')->andReturn('String representation of the Body object');
        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getParsedBody')->once()->andReturn($parsedJson);
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->once()->andReturn($body)
            ->shouldReceive('write');

        $authenticationService = \Mockery::mock('Zend\Authentication\AuthenticationService');
        $authenticationService->shouldReceive('getStorage')->once()->andReturn(new Session());

        $userService = \Mockery::mock('RudiBieller\OnkelRudi\User\UserService');
        $userService->shouldReceive('optIn')->once()->with('123abc456')->andReturn($serviceWasAbleToOptIn)
            ->shouldReceive('isLoggedIn')->andReturn(false);

        $wordpressService = \Mockery::mock('RudiBieller\OnkelRudi\Wordpress\ServiceInterface');
        $wordpressService->shouldReceive('getAllCategories')->andReturn([]);

        $action = new OptInAction();
        $action->setApp($app);
        $action->setWordpressService($wordpressService)
            ->setUserService($userService);

        $action($request, $response, array('token' => '123abc456'));

        $this->assertAttributeEquals(
            $expectedTemplateVariables,
            'templateVariables',
            $action
        );
    }

    public function dataProviderTestActionDoesOptInWhenGivenAValidToken()
    {
        return array(
            array(true, ['optin' => true]),
            array(false, ['optin' => true, 'optinfailed' => true])
        );
    }
}

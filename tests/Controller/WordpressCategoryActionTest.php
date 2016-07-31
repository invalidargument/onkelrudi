<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\Config\Config;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;
use RudiBieller\OnkelRudi\Wordpress\Category;
use Slim\App;
use Slim\Http\Body;

class WordpressCategoryActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionReturnsRequestedMarket()
    {
        $category = new Category();
        $category->setId(42);

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
        $container['config'] = new Config();
        $body = \Mockery::mock('Slim\HttpBody');
        $body->shouldReceive('write')
            ->shouldReceive('__toString')->andReturn('String representation of the Body object');
        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->once()->andReturn($body)
            ->shouldReceive('write');

        $wordpressService = \Mockery::mock('RudiBieller\OnkelRudi\Wordpress\ServiceInterface');
        $wordpressService->shouldReceive('getAllCategories')->andReturn([])
            ->shouldReceive('getPosts')->once()->with(\Hamcrest\Matchers::equalTo($category))->andReturn([]);

        $userService = \Mockery::mock('RudiBieller\OnkelRudi\User\UserServiceInterface');
        $userService->shouldReceive('isLoggedIn')->andReturn(false);

        $action = new WordpressCategoryAction();
        $action->setApp($app);
        $action->setWordpressService($wordpressService);
        $action->setUserService($userService);

        $return = $action($request, $response, array('id' => 42));
        $actual = (string)$return->getBody();
        $expected = 'String representation of the Body object';

        $this->assertContains($expected, $actual);
        $this->assertAttributeEquals(['selectedCategory' => 42], 'templateVariables', $action);
    }
}

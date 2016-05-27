<?php

namespace RudiBieller\OnkelRudi\Wordpress;

use RudiBieller\OnkelRudi\Config\Config;
use Slim\Container;

class CategoryReadListQueryTest extends \PHPUnit_Framework_TestCase
{
    public function testQueryReturnsMappedCategories()
    {
        $config = new Config('settings.yml.dist');
        $wpConfig = $config->getWordpressConfiguration();
        
        $category = new Category();
        $category
            ->setId(1)
            ->setCount(1)
            ->setParent(0)
            ->setName('Allgemein')
            ->setSlug('allgemein');

        $categoriesJson = file_get_contents(dirname(__FILE__).'/data/categories.json');

        $browser = \Mockery::mock('Buzz\Browser');
        $browser->shouldReceive('get')->once()->with('http://localhost/wordpress/wp-json/wp/v2/categories', ['Content-Type: application/json'], '')->andReturn($browser)
            ->shouldReceive('getContent')->andReturn($categoriesJson)
            ->shouldReceive('addListener')->with(\Hamcrest\Matchers::equalTo(new \Buzz\Listener\BasicAuthListener($wpConfig['auth-username'], $wpConfig['auth-password'])));

        $sut = new CategoryReadListQuery();
        $sut->setBrowser($browser);
        $sut->setDiContainer(new Container(['config' => $config]));

        $result = $sut->run();

        $this->assertEquals($category, $result[0]);
    }
}

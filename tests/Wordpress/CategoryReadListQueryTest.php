<?php

namespace RudiBieller\OnkelRudi\Wordpress;

use RudiBieller\OnkelRudi\Config\Config;

class CategoryReadListQueryTest extends \PHPUnit_Framework_TestCase
{
    public function testQueryReturnsMappedCategories()
    {
        $wpConfig = (new Config('settings.yml.dist'))->getWordpressConfiguration();
        
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

        $result = $sut->run();

        $this->assertEquals($category, $result[0]);
    }
}

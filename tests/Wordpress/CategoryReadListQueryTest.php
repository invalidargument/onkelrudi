<?php

namespace RudiBieller\OnkelRudi\Wordpress;

class CategoryReadListQueryTest extends \PHPUnit_Framework_TestCase
{
    public function testQueryReturnsMappedCategories()
    {
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
            ->shouldReceive('getContent')->andReturn($categoriesJson);

        $sut = new CategoryReadListQuery();
        $sut->setBrowser($browser);

        $result = $sut->run();

        $this->assertEquals($category, $result[0]);
    }
}

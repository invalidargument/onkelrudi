<?php

namespace RudiBieller\OnkelRudi\Wordpress;

class ServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAllCategoriesReturnsAllAvailableCategories()
    {
        $categories = array();

        $query = \Mockery::mock('RudiBieller\OnkelRudi\Wordpress\CategoryReadListQuery');
        $query->shouldReceive('run')->once()->andReturn($categories);

        $factory = \Mockery::mock('RudiBieller\OnkelRudi\Wordpress\QueryFactoryInterface');
        $factory->shouldReceive('createCategoryReadListQuery')->once()->andReturn($query);

        $sut = new Service();
        $sut->setQueryFactory($factory);

        $expected = array();

        $this->assertEquals($expected, $sut->getAllCategories());
    }
}

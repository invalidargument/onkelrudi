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

    public function testGetPostsReturnsRequestedPostsWithDefaultLimitAndOffset()
    {
        $selectedCategory = new Category();

        $posts = array();

        $query = \Mockery::mock('RudiBieller\OnkelRudi\Wordpress\PostReadListQuery');
        $query
            ->shouldReceive('setOffset')->once()->with(0)->andReturn($query)
            ->shouldReceive('setLimit')->once()->with(10)->andReturn($query)
            ->shouldReceive('run')->once()->andReturn($posts);

        $factory = \Mockery::mock('RudiBieller\OnkelRudi\Wordpress\QueryFactoryInterface');
        $factory->shouldReceive('createPostReadListQuery')->once()->andReturn($query);

        $sut = new Service();
        $sut->setQueryFactory($factory);

        $expected = array();

        $this->assertEquals($expected, $sut->getPosts($selectedCategory));
    }

    /**
     * @dataProvider dataProviderTestGetPostReturnsExpectedPostObject
     */
    public function testGetPostReturnsExpectedPostObject($id, $queryResult, $expectedResult)
    {
        $query = \Mockery::mock('RudiBieller\OnkelRudi\Wordpress\PostReadQuery');
        $query
            ->shouldReceive('setId')->once()->with($id)->andReturn($query)
            ->shouldReceive('run')->once()->andReturn($queryResult);

        $factory = \Mockery::mock('RudiBieller\OnkelRudi\Wordpress\QueryFactoryInterface');
        $factory->shouldReceive('createPostReadQuery')->once()->andReturn($query);

        $sut = new Service();
        $sut->setQueryFactory($factory);

        $this->assertEquals($expectedResult, $sut->getPost($id));
    }

    public function dataProviderTestGetPostReturnsExpectedPostObject()
    {
        $post = new Post();

        return array(
            array(42, $post, $post),
            array(23, null, null),
        );
    }
}

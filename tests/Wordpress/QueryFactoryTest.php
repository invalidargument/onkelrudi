<?php

namespace RudiBieller\OnkelRudi\Wordpress;

class QueryFactoryTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;

    protected function setUp()
    {
        $this->_sut = new QueryFactory();
    }

    /**
     * @dataProvider dataProviderTestFactoryCreatesDesiredQuery
     */
    public function testFactoryCreatesDesiredQuery($method, $expectedQuery)
    {
        $query = $this->_sut->$method();

        $this->assertInstanceOf(
            $expectedQuery,
            $query
        );
    }

    public function dataProviderTestFactoryCreatesDesiredQuery()
    {
        return array(
            array('createCategoryReadListQuery', 'RudiBieller\OnkelRudi\Wordpress\CategoryReadListQuery'),
            array('createPostReadListQuery', 'RudiBieller\OnkelRudi\Wordpress\PostReadListQuery')
        );
    }
}
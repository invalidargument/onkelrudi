<?php

namespace RudiBieller\OnkelRudi\User;

class QueryFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dateProviderTestFactoryCreatesQueriesAndReturnsThemWhenRequested
     */
    public function testFactoryCreatesQueriesAndReturnsThemWhenRequested($methodName, $expectedQuery)
    {
        $factory = new QueryFactory();

        $query = $factory->$methodName();

        $this->assertInstanceOf(
            $expectedQuery,
            $query
        );
    }

    public function dateProviderTestFactoryCreatesQueriesAndReturnsThemWhenRequested()
    {
        return array(
            array('createUserInsertQuery', 'RudiBieller\OnkelRudi\User\UserInsertQuery')
        );
    }
}

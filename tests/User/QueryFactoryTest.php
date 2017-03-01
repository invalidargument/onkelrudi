<?php

namespace RudiBieller\OnkelRudi\User;

use Slim\Container;

class QueryFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dateProviderTestFactoryCreatesQueriesAndReturnsThemWhenRequested
     */
    public function testFactoryCreatesQueriesAndReturnsThemWhenRequested($methodName, $expectedQuery)
    {
        $factory = new QueryFactory();
        $factory->setDiContainer(new Container());

        $query = $factory->$methodName();

        $this->assertInstanceOf(
            $expectedQuery,
            $query
        );
    }

    public function dateProviderTestFactoryCreatesQueriesAndReturnsThemWhenRequested()
    {
        return array(
            array('createUserInsertQuery', 'RudiBieller\OnkelRudi\User\InsertQuery'),
            array('createOptInTokenInsertQuery', 'RudiBieller\OnkelRudi\User\OptInTokenInsertQuery'),
            array('createOptInTokenUpdateQuery', 'RudiBieller\OnkelRudi\User\OptInTokenUpdateQuery'),
            array('createOptInTokenTestUpdateQuery', 'RudiBieller\OnkelRudi\User\OptInTokenTestUpdateQuery'),
            array('createUserReadQuery', 'RudiBieller\OnkelRudi\User\UserReadQuery'),
            array('createUserToOrganizerInsertQuery', 'RudiBieller\OnkelRudi\User\UserToOrganizerInsertQuery')
        );
    }
}

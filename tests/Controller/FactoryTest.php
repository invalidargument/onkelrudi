<?php

namespace RudiBieller\OnkelRudi\Controller;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FactoryInterface
     */
    private $_sut;
    private $_service;

    protected function setUp()
    {
        $this->_sut = new Factory(new \Slim\App());
        $this->_service = \Mockery::mock('RudiBieller\OnkelRudi\ServiceInterface');
        $this->_sut->setService($this->_service);
    }

    /**
     * @dataProvider createActionDataProvider
     */
    public function testCreateActionByNameReturnsAction($action, $expectedType)
    {
        $action = $this->_sut->createActionByName($action);

        $this->assertInstanceOf($expectedType, $action);
    }

    public function createActionDataProvider()
    {
        return array(
            array('RudiBieller\OnkelRudi\Controller\FleaMarketAction', 'RudiBieller\OnkelRudi\Controller\FleaMarketAction')
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCreateActionThrowsExceptionWhenActionCannotBeResolved()
    {
        $this->_sut->createActionByName('Foo');
    }
}

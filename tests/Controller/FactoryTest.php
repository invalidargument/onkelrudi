<?php

namespace RudiBieller\OnkelRudi\Controller;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FactoryInterface
     */
    private $_sut;
    private $_service;
    private $_organizerervice;
    private $_userService;

    protected function setUp()
    {
        $this->_sut = new Factory(new \Slim\App());
        $this->_service = \Mockery::mock('RudiBieller\OnkelRudi\ServiceInterface');
        $this->_organizerervice = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\OrganizerServiceInterface');
        $this->_userService = \Mockery::mock('RudiBieller\OnkelRudi\User\UserServiceInterface');
        
        $this->_sut->setService($this->_service);
        $this->_sut->setOrganizerService($this->_organizerervice);
        $this->_sut->setUserService($this->_userService);
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

    public function testCreateReturnsAlreadyCreatedInstances()
    {
        $createdAction = $this->_sut->createActionByName('RudiBieller\OnkelRudi\Controller\FleaMarketAction');
        $cachedAction = $this->_sut->createActionByName('RudiBieller\OnkelRudi\Controller\FleaMarketAction');

        $this->assertSame($createdAction, $cachedAction);
    }
}

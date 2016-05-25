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
    private $_notificationService;

    protected function setUp()
    {
        $this->_sut = new Factory(new \Slim\App());
        $this->_service = \Mockery::mock('RudiBieller\OnkelRudi\ServiceInterface');
        $this->_organizerervice = \Mockery::mock('RudiBieller\OnkelRudi\FleaMarket\OrganizerServiceInterface');
        $this->_userService = \Mockery::mock('RudiBieller\OnkelRudi\User\UserServiceInterface');
        $this->_notificationService = \Mockery::mock('RudiBieller\OnkelRudi\User\NotificationServiceInterface');

        $this->_sut->setService($this->_service);
        $this->_sut->setOrganizerService($this->_organizerervice);
        $this->_sut->setUserService($this->_userService);
        $this->_sut->setNotificationService($this->_notificationService);
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
            array('RudiBieller\OnkelRudi\Controller\Api\FleaMarketAction', 'RudiBieller\OnkelRudi\Controller\Api\FleaMarketAction')
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
        $createdAction = $this->_sut->createActionByName('RudiBieller\OnkelRudi\Controller\Api\FleaMarketAction');
        $cachedAction = $this->_sut->createActionByName('RudiBieller\OnkelRudi\Controller\Api\FleaMarketAction');

        $this->assertSame($createdAction, $cachedAction);
    }
}

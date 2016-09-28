<?php

namespace RudiBieller\OnkelRudi\User;

class UserBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProviderTestBuilderBuildsAvailableUserTypes
     */
    public function testBuilderBuildsAvailableUserTypes($requestedType, $expectedObjectType)
    {
        $sut = new UserBuilder();
        $sut
            ->setIdentifier('foo@example.com')
            ->setPassword('123')
            ->setOptIn(true)
            ->setType($requestedType);

        $this->assertInstanceOf($expectedObjectType, $sut->build());
    }

    public function dataProviderTestBuilderBuildsAvailableUserTypes()
    {
        return array(
            array(UserInterface::TYPE_ORGANIZER, 'RudiBieller\OnkelRudi\User\Organizer'),
            array(UserInterface::TYPE_ADMIN, 'RudiBieller\OnkelRudi\User\Admin'),
            array(UserInterface::TYPE_USER, 'RudiBieller\OnkelRudi\User\User'),
            array('invalid', 'RudiBieller\OnkelRudi\User\User')
        );
    }

    public function testResetResetsGivenValues()
    {
        $sut = new UserBuilder();
        $sut
            ->setIdentifier('foo@example.com')
            ->setPassword('123')
            ->setOptIn(true)
            ->setType(UserInterface::TYPE_ADMIN);

        $sut->reset();

        $user = $sut->build();

        $this->assertInstanceOf('RudiBieller\OnkelRudi\User\User', $user);
        $this->assertNull($user->getIdentifier());
        $this->assertNull($user->getPassword());
        $this->assertFalse($user->hasOptIn());
    }
}

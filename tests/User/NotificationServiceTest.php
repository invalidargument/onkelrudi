<?php

namespace RudiBieller\OnkelRudi\User;

use RudiBieller\OnkelRudi\Config\Config;

class NotificationServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testOptInEmailIsSent()
    {
        $sut = new NotificationService();
        $sut->setConfig(new Config('settings.yml.dist'));

        $mailer = \Mockery::mock('PHPMailer');
        $mailer
            ->shouldReceive('isSMTP')->once()
            ->shouldReceive('setFrom')->once()->with('info@onkel-rudi.de', 'onkel-rudi.de')
            ->shouldReceive('addAddress')->once()->with('foo@bar.com')
            ->shouldReceive('isHTML')->once()->with(false)
            ->shouldReceive('send')->once()->andReturn(true);
        $sut->setMailer($mailer);

        $this->assertTrue($sut->sendOptInNotification('foo@bar.com', 'my message'));
    }
}

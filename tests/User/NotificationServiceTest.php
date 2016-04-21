<?php

namespace RudiBieller\OnkelRudi\User;

class NotificationServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testOptInEmailIsSent()
    {
        $sut = new NotificationService();
        $mailer = \Mockery::mock('PHPMailer');
        $mailer
            ->shouldReceive('isSMTP')->once()
            ->shouldReceive('setFrom')->once()->with('info@onkel-rudi.de', 'onkelrudi.de')
            ->shouldReceive('addAddress')->once()->with('foo@bar.com')
            ->shouldReceive('isHTML')->once()->with(false)
            ->shouldReceive('send')->once()->andReturn(true);
        $sut->setMailer($mailer);

        $this->assertTrue($sut->sendOptInNotification('foo@bar.com', 'my message'));
    }
}

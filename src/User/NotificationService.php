<?php

namespace RudiBieller\OnkelRudi\User;

class NotificationService implements NotificationServiceInterface
{
    /**
     * @var \PHPMailer
     */
    private $_mailer;

    public function setMailer(\PHPMailer $phpmailer)
    {
        $this->_mailer = $phpmailer;
    }

    public function getMailer()
    {
        if (is_null($this->_mailer)) {
            $this->_mailer = new \PHPMailer();
        }

        return $this->_mailer;
    }

    public function sendOptInNotification($email, $message)
    {
        $this->_mailer->isSendmail();
        $this->_mailer->setFrom('info@onkel-rudi.de', 'onkelrudi.de');
        $this->_mailer->addAddress($email);
        $this->_mailer->isHTML(false);
        $this->_mailer->Subject = 'Bitte bestätige Deine Registrierung bei onkel-rudi.de!';
        $this->_mailer->Body = $message;

        return $this->_mailer->send();
    }
}

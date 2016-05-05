<?php

namespace RudiBieller\OnkelRudi\User;

use RudiBieller\OnkelRudi\Config\Config;

class NotificationService implements NotificationServiceInterface
{
    /**
     * @var \PHPMailer
     */
    private $_mailer;

    /**
     * @var Config
     */
    private $_config;

    public function setMailer(\PHPMailer $phpmailer)
    {
        $this->_mailer = $phpmailer;
    }

    public function setConfig(Config $config)
    {
        $this->_config = $config;
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
        if (is_null($this->_config)) {
            $this->_config = new Config();
        }

        $settings = $this->_config->getMailConfiguration();
        $systemSettings = $this->_config->getSystemConfiguration();

        if ($systemSettings['environment'] === 'debug') {
            $this->getMailer()->SMTPDebug = 3;
        }

        $this->getMailer()->isSMTP();
        $this->getMailer()->CharSet = 'UTF-8';
        $this->getMailer()->Host = $settings['smtp-host'];
        $this->getMailer()->SMTPAuth = true;
        $this->getMailer()->Username = $settings['smtp-username'];
        $this->getMailer()->Password = $settings['smtp-password'];
        $this->getMailer()->AuthType = $settings['smtp-authentication-method'];
        $this->getMailer()->SMTPSecure = $settings['smtp-transport-security'];
        $this->getMailer()->Port = $settings['smtp-port'];


        $this->getMailer()->setFrom('info@onkel-rudi.de', 'onkel-rudi.de');
        $this->getMailer()->addAddress($email);
        $this->getMailer()->isHTML(false);
        $this->getMailer()->Subject = 'Bitte bestätige Deine Registrierung bei onkel-rudi.de!';
        $this->getMailer()->Body = $message;

        return $this->getMailer()->send();
    }
}

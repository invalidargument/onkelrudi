<?php

namespace RudiBieller\OnkelRudi\User;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Zend\Session\Config\SessionConfig;
use Zend\Session\SessionManager;

class AuthenticationFactory
{
    public function createAuthService($authAdapter, $sessionStorage)
    {
        $authService = new AuthenticationService();
        $authService->setAdapter($authAdapter)
            ->setStorage($sessionStorage);

        return $authService;
    }

    public function createAuthAdapter($identifier, $password)
    {
        $authAdapter = new DbAuthenticationAdapter();
        $authAdapter->setIdentifier($identifier)->setPassword($password);

        return $authAdapter;
    }

    public function createSessionStorage()
    {
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions(array(
            'remember_me_seconds' => 60 * 60 * 24 * 7,
            'cookie_lifetime' => 60 * 60 * 24 * 7,
            'name' => 'onkelrudi',
            'use_cookies' => true
        ));
        $sessionManager = new SessionManager($sessionConfig);
        $sessionManager->setConfig($sessionConfig);
        $sessionStorage = new Session(null, null, $sessionManager);

        return $sessionStorage;
    }
}

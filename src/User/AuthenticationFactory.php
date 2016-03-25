<?php

namespace RudiBieller\OnkelRudi\User;

use Zend\Authentication\AuthenticationService;

class AuthenticationFactory
{
    public function createAuthService($authAdapter, $sessionStorage = null)
    {
        $sessionStorage = null;

        $authService = new AuthenticationService();
        $authService->setAdapter($authAdapter);

        return $authService;
    }

    public function createAuthAdapter($identifier, $password)
    {
        $authAdapter = new DbAuthenticationAdapter();
        $authAdapter->setIdentifier($identifier)->setPassword($password);

        return $authAdapter;
    }
}

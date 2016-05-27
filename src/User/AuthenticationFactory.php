<?php

namespace RudiBieller\OnkelRudi\User;

use Slim\Container;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Zend\Session\Config\SessionConfig;
use Zend\Session\SessionManager;

class AuthenticationFactory
{
    private $_authenticationService = null;
    private $_authenticationAdapter = null;
    private $_sessionStorage = null;

    private $_diContainer;

    public function setDiContainer(Container $diContainer)
    {
        $this->_diContainer = $diContainer;
    }

    public function createAuthService($authAdapter, $sessionStorage)
    {
        if (is_null($this->_authenticationService)) {
            $this->_authenticationService = new AuthenticationService();
            $this->_authenticationService->setAdapter($authAdapter)
                ->setStorage($sessionStorage);
        }

        return $this->_authenticationService;
    }

    public function createAuthAdapter(UserInterface $user = null)
    {
        if (is_null($this->_authenticationAdapter)) {
            $this->_authenticationAdapter = new DbAuthenticationAdapter();
            $this->_authenticationAdapter->setDiContainer($this->_diContainer);
            if (!is_null($user)) {
                $this->_authenticationAdapter
                    ->setIdentifier($user->getIdentifier())
                    ->setPassword($user->getPassword());
            }
        }

        return $this->_authenticationAdapter;
    }

    public function createSessionStorage()
    {
        if (is_null($this->_sessionStorage)) {
            $sessionConfig = new SessionConfig();
            $sessionConfig->setOptions(array(
                'remember_me_seconds' => 60 * 60 * 24 * 7,
                'cookie_lifetime' => 60 * 60 * 24 * 7,
                'name' => 'onkelrudi',
                'use_cookies' => true
            ));
            $sessionManager = new SessionManager($sessionConfig);
            $sessionManager->setConfig($sessionConfig);
            $this->_sessionStorage = new Session(null, null, $sessionManager);
        }

        return $this->_sessionStorage;
    }
}

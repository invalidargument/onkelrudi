<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\Controller\AbstractJsonAction;
use RudiBieller\OnkelRudi\User\User;
use Zend\Authentication\Result;

class UserLoginAction extends AbstractJsonAction
{
    private $_passwordsDontMatchStatusCode;
    private $_passwordsDontMatchStatusMessage;

    protected function getData()
    {
        $data = $this->request->getParsedBody();

        $user = new User($data['email'], $data['password']);

        /**
         * @var \Zend\Authentication\Result
         */
        $result = $this->userService->getAuthenticationService($user)->authenticate();

        if (!$result->isValid()) {
            switch ($result->getCode()) {
                case Result::FAILURE_IDENTITY_NOT_FOUND:
                    $this->_passwordsDontMatchStatusMessage = 'User not found';
                    break;
                case Result::FAILURE_CREDENTIAL_INVALID:
                    $this->_passwordsDontMatchStatusMessage = 'Login credentials not valid';
                    break;
                default:
                    $this->_passwordsDontMatchStatusMessage = 'Error logging in';
                    break;
            }
            $this->_passwordsDontMatchStatusCode = 403;
            return null;
        }

        //$loadedUser = $this->userService->getUser($user->getIdentifier());
        //var_dump($loadedUser);die;

        $this->userService->getAuthenticationService($user)->getStorage()->write(
            array(
                'authenticated' => true,
                'username' => $user->getIdentifier()
            )
        );

        return true;
    }

    protected function getResponseErrorStatusCode()
    {
        return $this->_passwordsDontMatchStatusCode;
    }

    protected function getResponseErrorStatusMessage()
    {
        return $this->_passwordsDontMatchStatusMessage;
    }
}

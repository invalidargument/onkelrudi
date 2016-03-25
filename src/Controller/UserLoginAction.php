<?php

namespace RudiBieller\OnkelRudi\Controller;

use Zend\Authentication\Result;

class UserLoginAction extends AbstractJsonAction
{
    private $_passwordsDontMatchStatusCode;
    private $_passwordsDontMatchStatusMessage;

    protected function getData()
    {
        $data = $this->request->getParsedBody();

        $result = $this->userService->login($data['email'], $data['password']);

        if (!$result->isValid()) {
            switch($result->getCode()) {
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
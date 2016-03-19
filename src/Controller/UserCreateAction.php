<?php

namespace RudiBieller\OnkelRudi\Controller;

class UserCreateAction extends AbstractJsonAction
{
    private $_passwordsDontMatchStatusCode;
    private $_passwordsDontMatchStatusMessage;

    protected function getData()
    {
        $data = $this->request->getParsedBody();

        if (!$this->_passwordIsValid($data['password'], $data['password_repeat'])) {
            return null;
        }

        return $this->userService->createUser(
            $data['email'],
            $data['password']
        );
    }

    private function _passwordIsValid($password1, $password2)
    {
        if ($password1 !== $password2) {
            $this->_passwordsDontMatchStatusCode = 401;
            $this->_passwordsDontMatchStatusMessage = 'Passwords do not match';
            return false;
        }

        if (strlen($password1) < 8) {
            $this->_passwordsDontMatchStatusCode = 401;
            $this->_passwordsDontMatchStatusMessage = 'Passwords must have at least a length of 8 chracters';
            return false;
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

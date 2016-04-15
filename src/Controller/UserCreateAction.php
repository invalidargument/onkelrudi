<?php

namespace RudiBieller\OnkelRudi\Controller;

class UserCreateAction extends AbstractJsonAction
{
    protected $template = 'notificationOptIn.html';
    private $_passwordsDontMatchStatusCode;
    private $_passwordsDontMatchStatusMessage;

    protected function getData()
    {
        $data = $this->request->getParsedBody();

        if (!$this->_passwordIsValid($data['password'], $data['password_repeat'])) {
            return null;
        }

        $result = null;

        try {
            $result = $this->userService->createUser(
                $data['email'],
                password_hash($data['password'], PASSWORD_DEFAULT) // TODO: should be done elsewhere, service for example
            );
        } catch (\PDOException $e) {
            $this->_passwordsDontMatchStatusCode = 400;
            $this->_passwordsDontMatchStatusMessage = 'Primary identifier already exists in database';

            return null;
        }

        $token = $this->userService->createOptInToken($data['email']);
        $this->templateVariables = ['token' => $token];

        // generate rendered mail text
        $optInText = $this->app->getContainer()->get('view')
            ->render(
                $this->response,
                $this->template,
                array_merge(
                    ['data' => $this->result],
                    $this->templateVariables
                )
            );

        return $result;
    }

    private function _passwordIsValid($password1, $password2)
    {
        if ($password1 !== $password2) {
            $this->_passwordsDontMatchStatusCode = 400;
            $this->_passwordsDontMatchStatusMessage = 'Passwords do not match';
            return false;
        }

        if (strlen($password1) < 8) {
            $this->_passwordsDontMatchStatusCode = 400;
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

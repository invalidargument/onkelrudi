<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\Controller\AbstractJsonAction;
use RudiBieller\OnkelRudi\User\NotificationService;
use RudiBieller\OnkelRudi\User\User;
use RudiBieller\OnkelRudi\User\UserInterface;

class UserCreateAction extends AbstractJsonAction
{
    protected $template = 'notificationOptIn.html';
    private $_passwordsDontMatchStatusCode;
    private $_passwordsDontMatchStatusMessage;

    protected function getData()
    {
        $data = $this->request->getParsedBody();

        if (!$this->_emailIsValid($data['email'])) {
            return null;
        }

        if (!$this->_passwordIsValid($data['password'], $data['password_repeat'])) {
            return null;
        }

        $result = null;
        $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);

        try {
            $userType = $this->_getType($data);

            switch ($userType) {
                case UserInterface::TYPE_ORGANIZER:
                    $result = $this->userService->createOrganizerUser(
                        $email,
                        password_hash($data['password'], PASSWORD_DEFAULT) // TODO: should be done elsewhere, service for example
                    );
                    break;
                case UserInterface::TYPE_ADMIN:
                    $result = $this->userService->createAdminUser(
                        $email,
                        password_hash($data['password'], PASSWORD_DEFAULT) // TODO: should be done elsewhere, service for example
                    );
                    break;
                default:
                    $result = $this->userService->createUser(
                        $email,
                        password_hash($data['password'], PASSWORD_DEFAULT) // TODO: should be done elsewhere, service for example
                    );
            }
        } catch (\PDOException $e) {
            $this->_passwordsDontMatchStatusCode = 400;
            $this->_passwordsDontMatchStatusMessage = 'Primary identifier already exists in database';

            return null;
        }

        $token = $this->userService->createOptInToken($email);
        $this->templateVariables = ['token' => $token];

        // generate rendered mail text
        $optInText = $this->app->getContainer()->get('view')
            ->fetch(
                $this->template,
                array_merge(
                    ['data' => $this->result],
                    $this->templateVariables
                )
            );

        $this->notificationService->sendOptInNotification($email, $optInText);

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
            $this->_passwordsDontMatchStatusMessage = 'Passwords must have a minimum length of 8 chracters';
            return false;
        }

        return true;
    }

    private function _emailIsValid($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $this->_passwordsDontMatchStatusCode = 400;
            $this->_passwordsDontMatchStatusMessage = 'No valid e-mail address';
            return false;
        }

        return true;
    }

    private function _getType($requestParameterData)
    {
        if (!array_key_exists('register_as_organizer', $requestParameterData)) {
            return UserInterface::TYPE_USER;
        }

        if ($requestParameterData['register_as_organizer']) {
            return UserInterface::TYPE_ORGANIZER;
        }
        
        return UserInterface::TYPE_USER;
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

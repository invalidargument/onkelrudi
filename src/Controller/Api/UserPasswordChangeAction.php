<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\Controller\AbstractJsonAction;
use RudiBieller\OnkelRudi\Controller\UserAwareInterface;

class UserPasswordChangeAction extends AbstractJsonAction implements UserAwareInterface
{
    private $_passwordsDontMatchStatusCode = 400;
    private $_passwordsDontMatchStatusMessage;

    protected function getData()
    {
        $data = $this->request->getParsedBody();
        $oldPassword = $data['password_old'];
        $newPassword = $data['password_new'];
        $newPasswordRepeated = $data['password_new_repeated'];

        $email = $this->userService
            ->getAuthenticationService()
            ->getStorage()
            ->read()
            ->getIdentifier();

        // TODO: validate current password
        if (!$this->_currentPasswordIsValid($oldPassword)) {
            $this->_passwordsDontMatchStatusMessage = 'Current password does not match';
            return null;
        }

        // this should go to a separate service, see also UserCreateAction
        if (!$this->_passwordIsValid($newPassword, $newPasswordRepeated)) {
            return null;
        }

        /**
         * @var UserBuilder
         */
        $userBuilder = $this->builderFactory->create('RudiBieller\OnkelRudi\User\UserBuilder');
        $user = $userBuilder->setIdentifier($email)->setPassword($oldPassword)->build();

        $result = $this->userService->changePassword($user, $newPassword);

        if (!$result) {
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

    private function _currentPasswordIsValid($currentPassword)
    {
        return true;
    }

    private function _passwordIsValid($password1, $password2)
    {
        if ($password1 !== $password2) {
            $this->_passwordsDontMatchStatusMessage = 'New passwords do not match';
            return false;
        }

        if (strlen($password1) < 8) {
            $this->_passwordsDontMatchStatusMessage = 'Passwords must have a minimum length of 8 chracters';
            return false;
        }

        return true;
    }
}

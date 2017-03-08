<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\Controller\AbstractJsonAction;
use RudiBieller\OnkelRudi\Controller\UserAwareInterface;

class UserPasswordChangeAction extends AbstractJsonAction implements UserAwareInterface
{
    private $_passwordsDontMatchStatusCode;
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

        if ($newPassword !== $newPasswordRepeated) {
            $this->_passwordsDontMatchStatusMessage = 'Das neue Passwort muss zwei Mal identisch eingegeben werden.';
            $this->_passwordsDontMatchStatusCode = 400;
            return null;
        }

        // TODO passwortlänge prüfen

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
}

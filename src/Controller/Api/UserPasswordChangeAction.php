<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\Controller\AbstractJsonAction;

class UserPasswordChangeAction extends AbstractJsonAction
{
    private $_passwordsDontMatchStatusCode;
    private $_passwordsDontMatchStatusMessage;

    protected function getData()
    {
        $data = $this->request->getParsedBody();
        $oldPassword = $data['identifier_password_old'];
        $newPassword = $data['identifier_password_new'];
        $newPasswordRepeated = $data['identifier_password_new_repeated'];
        $email = filter_var($this->args['id'], FILTER_VALIDATE_EMAIL);

        if ($newPassword !== $newPasswordRepeated) {
            $this->_passwordsDontMatchStatusMessage = 'Das neue Passwort muss zwei Mal identisch eingegeben werden.';
            $this->_passwordsDontMatchStatusCode = 400;
            return false;
        }

        /**
         * @var UserBuilder
         */
        $userBuilder = $this->builderFactory->create('RudiBieller\OnkelRudi\User\UserBuilder');
        $user = $userBuilder->setIdentifier($email)->setPassword($oldPassword)->build();

        return $this->userService->changePassword($user, $newPassword);
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

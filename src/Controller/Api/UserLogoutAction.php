<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\Controller\AbstractJsonAction;

class UserLogoutAction extends AbstractJsonAction
{
    protected function getData()
    {
        $user = $this->userService->getAuthenticationService()->getStorage()->read();

        if (!is_null($user)) {
            $this->userService->getAuthenticationService()->getStorage()->clear();
            $this->userService->getAuthenticationService()->clearIdentity();
        }

        return true;
    }
}

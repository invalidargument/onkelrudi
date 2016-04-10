<?php

namespace RudiBieller\OnkelRudi\Controller;

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

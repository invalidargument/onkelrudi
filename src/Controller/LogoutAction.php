<?php

namespace RudiBieller\OnkelRudi\Controller;

class LogoutAction extends AbstractHttpAction
{
    protected $template = 'logout.html';

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
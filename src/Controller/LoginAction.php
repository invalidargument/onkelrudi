<?php

namespace RudiBieller\OnkelRudi\Controller;

class LoginAction extends AbstractHttpAction
{
    protected $template = 'loginRegister.html';

    protected function getData()
    {
        $user = $this->userService->getAuthenticationService()->getStorage()->read();

        if (!is_null($user)) {
            $this->templateVariables['loggedIn'] = true;
        }

        $this->templateVariables['profileurl'] = $this->app->getContainer()->get('router')->pathFor('profile');

        return array();
    }
}

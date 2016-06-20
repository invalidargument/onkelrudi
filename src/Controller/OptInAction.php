<?php

namespace RudiBieller\OnkelRudi\Controller;

class OptInAction extends AbstractHttpAction
{
    protected $template = 'loginRegister.html';

    protected function getData()
    {
        $this->templateVariables['optin'] = true;

        $token = $this->args['token'];

        $success = $this->userService->optIn($token);

        if (!$success) {
            $this->templateVariables['optinfailed'] = true;
        }

        $this->templateVariables['profileurl'] = $this->app->getContainer()->get('router')->pathFor('profile');

        return array();
    }
}

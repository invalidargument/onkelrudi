<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\User\User;

class ProfileAction extends AbstractHttpAction implements UserAwareInterface
{
    protected $template = 'profile.html';

    protected function getData()
    {
        $data = $this->userService->getAuthenticationService()->getStorage()->read();

        $user = new User($data['username']);

        $myFleamarkets = $this->service->getFleaMarketsByUser($user, 20, 0);

        $data['user'] = $user;

        $this->templateVariables['profileurl'] = $this->app->getContainer()->get('router')->pathFor('login-register');
        $this->templateVariables['createfleamarketurl'] = $this->app->getContainer()->get('router')->pathFor('create-fleamarket');
        $this->templateVariables['fleamarkets'] = $myFleamarkets;

        return $data;
    }
}

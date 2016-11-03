<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\User\Organizer;

class ProfileAction extends AbstractHttpAction implements UserAwareInterface
{
    protected $template = 'profile.html';

    protected function getData()
    {
        $user = $this->userService->getAuthenticationService()->getStorage()->read();

        $page = array_key_exists('page', $this->args)
            ? (int) $this->args['page']
            : 0;

        if ($page < 0) {
            $page = 0;
        }

        $offset = $page === 0
            ? 0
            : $page - 1;

        $myFleamarkets = $this->service->getFleaMarketsByUser($user, 20, $offset);

        $organizer = null;
        if ($user instanceof Organizer) {
            $organizer = $this->organizerService->getOrganizerByUserId($user->getIdentifier());
        }

        $this->templateVariables['profileurl'] = $this->app->getContainer()->get('router')->pathFor('login-register');
        $this->templateVariables['createfleamarketurl'] = $this->app->getContainer()->get('router')->pathFor('create-fleamarket');
        $this->templateVariables['fleamarkets'] = $myFleamarkets;
        $this->templateVariables['organizer'] = $organizer;
        $this->templateVariables['profileurl'] = $this->app->getContainer()->get('router')->pathFor('profile');
        $this->templateVariables['page'] = $page;

        return $user;
    }
}

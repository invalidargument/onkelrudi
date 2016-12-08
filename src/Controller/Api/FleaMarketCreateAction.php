<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\Controller\AbstractJsonAction;
use RudiBieller\OnkelRudi\Controller\UserAwareInterface;
use RudiBieller\OnkelRudi\FleaMarket\Builder;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;
use RudiBieller\OnkelRudi\User\Admin;

class FleaMarketCreateAction extends AbstractJsonAction implements UserAwareInterface
{
    protected function getData()
    {
        /**
         * @var Builder
         */
        $builder = $this->builderFactory->create('RudiBieller\OnkelRudi\FleaMarket\Builder');
        $builder->reset();

        $builder->setUser(
            $this->userService->getAuthenticationService()->getStorage()->read()
        );

        $data = $this->request->getParsedBody();

        if (array_key_exists('organizerId', $data)) {
            $organizer = new Organizer();
            $organizer->setId($data['organizerId']);
            $data['organizer'] = $organizer;
            unset($data['organizerId']);
        }

        // TODO if incomplete, return error

        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($builder, $method)) {
                $builder->$method($value);
            }
        }

        $user = $this->userService->getAuthenticationService()->getStorage()->read();

        $autoApprove = false;
        if ($user instanceof Admin) {
            $autoApprove = true;
        }

        return $this->service->createFleaMarket($builder->build(), $autoApprove);
    }
}

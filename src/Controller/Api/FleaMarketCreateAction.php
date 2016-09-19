<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\Controller\AbstractJsonAction;
use RudiBieller\OnkelRudi\Controller\UserAwareInterface;
use RudiBieller\OnkelRudi\FleaMarket\Builder;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDate;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;
use RudiBieller\OnkelRudi\User\User;

class FleaMarketCreateAction extends AbstractJsonAction implements UserAwareInterface
{
    protected function getData()
    {
        /**
         * @var Builder
         */
        $builder = $this->builderFactory->create('RudiBieller\OnkelRudi\FleaMarket\Builder');
        $builder->reset();

        $userInfo = $this->userService->getAuthenticationService()->getStorage()->read();
        $builder->setUser(
            $this->_mapUser($userInfo['username'])
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

        return $this->service->createFleaMarket($builder->build());
    }

    private function _mapUser($identifier)
    {
        return new User($identifier);
    }
}

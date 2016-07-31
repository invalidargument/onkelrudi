<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\Controller\AbstractJsonAction;
use RudiBieller\OnkelRudi\Controller\UserAwareInterface;
use RudiBieller\OnkelRudi\FleaMarket\Builder;

class OrganizerCreateAction extends AbstractJsonAction implements UserAwareInterface
{
    protected function getData()
    {
        /**
         * @var Builder
         */
        $builder = $this->builderFactory->create('RudiBieller\OnkelRudi\FleaMarket\OrganizerBuilder');
        $builder->reset();

        $data = $this->request->getParsedBody();

        // if incomplete, return error

        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($builder, $method)) {
                $builder->$method($value);
            }
        }

        return $this->organizerService->createOrganizer($builder->build());
    }
}

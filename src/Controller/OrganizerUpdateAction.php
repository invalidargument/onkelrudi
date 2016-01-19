<?php

namespace RudiBieller\OnkelRudi\Controller;

class OrganizerUpdateAction extends AbstractJsonAction
{
    protected function getData()
    {
        /**
         * @var Builder
         */
        $builder = $this->builderFactory->create('RudiBieller\OnkelRudi\FleaMarket\OrganizerBuilder');
        $builder->reset();

        $organizerId = $this->args['id'];

        // if not found, return 404

        $builder->setId($organizerId);

        $data = $this->request->getParsedBody();

        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($builder, $method)) {
                $builder->$method($value);
            }
        }

        return $this->organizerService->updateOrganizer($builder->build());
    }
}

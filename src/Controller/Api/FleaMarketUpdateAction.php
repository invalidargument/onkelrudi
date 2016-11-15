<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\Controller\AbstractJsonAction;
use RudiBieller\OnkelRudi\Controller\UserAwareInterface;

class FleaMarketUpdateAction extends AbstractJsonAction implements UserAwareInterface
{
    protected function getData()
    {
        /**
         * @var \RudiBieller\OnkelRudi\FleaMarket\Builder
         */
        $fleaMarketBuilder = $this->builderFactory->create('RudiBieller\OnkelRudi\FleaMarket\Builder');
        $fleaMarketBuilder->reset();

        $fleaMarketId = $this->args['id'];

        // if not found, return 404

        $fleaMarketBuilder->setId($fleaMarketId);

        $data = $this->request->getParsedBody();

        //TODO
        //$this->app->getContainer()->get('Logger')->critical(var_export($data, true));

        if (array_key_exists('organizer', $data)) {
            $data['organizer'] = $this->_buildOrganizer($data['organizer']);
        }

        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($fleaMarketBuilder, $method)) {
                $fleaMarketBuilder->$method($value);
            }
        }

        return $this->service->updateFleaMarket($fleaMarketBuilder->build());
    }

    private function _buildOrganizer($data)
    {
        $organizerBuilder = $this->builderFactory->create('RudiBieller\OnkelRudi\FleaMarket\OrganizerBuilder');
        $organizerBuilder->reset();

        // TODO this is crap
        $data = json_decode($data, true);

        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($organizerBuilder, $method)) {
                $organizerBuilder->$method($value);
            }
        }

        return $organizerBuilder->build();
    }
}

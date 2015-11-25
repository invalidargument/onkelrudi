<?php
namespace RudiBieller\OnkelRudi\FleaMarket\Query;

use RudiBieller\OnkelRudi\Query\AbstractInsertQuery;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDetailsInterface;

class FleaMarketDetailsUpdateQuery extends AbstractInsertQuery
{
    /**
     * @var \RudiBieller\OnkelRudi\FleaMarket\FleaMarketDetails
     */
    private $_details;

    public function setDetails(FleaMarketDetailsInterface $details)
    {
        $this->_details = $details;
        return $this;
    }

    protected function runQuery()
    {
        $updateStatement = $this->pdo
            ->update(
                array(
                    'fleamarket_id' => $this->_details->getFleaMarketId(), // TODO: do we want to update this?
                    'description' => $this->_details->getDescription(),
                    'start' => $this->_details->getStart(),
                    'end' => $this->_details->getEnd(),
                    'street' => $this->_details->getStreet(),
                    'streetno' => $this->_details->getStreetNo(),
                    'city' => $this->_details->getCity(),
                    'zipcode' => $this->_details->getZipCode(),
                    'location' => $this->_details->getLocation(),
                    'url' => $this->_details->getUrl()
                )
            )
            ->table('fleamarkets_details')
            ->where('id', '=', $this->_details->getId());

        return $updateStatement->execute();
    }
}

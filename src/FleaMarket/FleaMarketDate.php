<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

class FleaMarketDate
{
    private $_start;
    private $_end;

    public function __construct($start = null, $end = null)
    {
        $this->setStart($start)->setEnd($end);
    }

    /**
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->_start;
    }

    /**
     * @param \DateTime $start
     * @return FleaMarketDate
     */
    public function setStart($start)
    {
        $this->_start = $start;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->_end;
    }

    /**
     * @param \DateTime $end
     * @return FleaMarketDate
     */
    public function setEnd($end)
    {
        $this->_end = $end;
        return $this;
    }
}

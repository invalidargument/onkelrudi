<?php

namespace RudiBieller\OnkelRudi\FleaMarket;

class FleaMarketDate implements \JsonSerializable
{
    private $_start;
    private $_end;

    public function __construct($start = null, $end = null)
    {
        $this->setStart($start)->setEnd($end);
    }

    public function getStart()
    {
        return $this->_start;
    }

    public function setStart($start)
    {
        $this->_start = $start;
        return $this;
    }

    public function getEnd()
    {
        return $this->_end;
    }

    public function setEnd($end)
    {
        $this->_end = $end;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'start' => $this->getStart(),
            'end' => $this->getEnd()
        ];
    }
}

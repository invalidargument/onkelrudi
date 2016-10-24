<?php

namespace RudiBieller\OnkelRudi\Ical;

use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;

interface ServiceInterface
{
    public function createCalendarEvent(FleaMarket $fleamarket, \DateTime $date);
}

<?php

namespace RudiBieller\OnkelRudi\Ical;

use Eluceo\iCal\Component\Calendar;
use Eluceo\iCal\Component\Event;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;

class Service implements ServiceInterface
{
    public function createCalendarEvent(FleaMarket $fleamarket, \DateTime $date)
    {
        $vCalendar = new Calendar('www.onkel-rudi.de');
        $vEvent = new Event();
        $vEvent
            ->setUseUtc(false)
            ->setUrl($fleamarket->getUrl())
            ->setLocation(
            $fleamarket->getLocation() . ', ' . $fleamarket->getStreet() . ' ' . $fleamarket->getStreetNo() . ', ' .
            $fleamarket->getZipCode() . ' ' . $fleamarket->getCity()
        );

        foreach ($fleamarket->getDates() as $currentDate) {
            $ds = new \DateTime($currentDate->getStart());
            $de = new \DateTime($currentDate->getEnd());
            if ($ds->format('Ymd') == $date->format('Ymd')) {
                $vEvent
                    ->setDtStart(new \DateTime($ds->format('Y-m-d H:i:s')))
                    ->setDtEnd(new \DateTime($de->format('Y-m-d H:i:s')))
                    ->setNoTime(false)
                    ->setSummary($fleamarket->getName())
                ;
                break;
            }
        }

        $vCalendar->addComponent($vEvent);

        return $vCalendar->render();
    }
}

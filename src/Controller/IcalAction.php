<?php

namespace RudiBieller\OnkelRudi\Controller;

class IcalAction extends AbstractIcalAction
{
    protected function getData()
    {
        $fleamarketId = $this->args['id'];
        $selectedDate = $this->args['date'];

        return $this->icalService->createCalendarEvent(
            $this->service->getFleaMarket($fleamarketId),
            new \DateTime($selectedDate)
        );
    }
}

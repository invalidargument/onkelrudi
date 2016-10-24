<?php

namespace RudiBieller\OnkelRudi\Ical;

use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDate;

class ServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProviderTestServiceCreatesFleamarketDateCalendarEvent
     */
    public function testServiceCreatesFleamarketDateCalendarEvent(array $dates, \DateTime $selectedDate, $expectedStart, $expectedEnd)
    {
        $fleamarket = new FleaMarket();
        $fleamarket->setDates($dates);

        $sut = new Service();
        $result = $sut->createCalendarEvent($fleamarket, $selectedDate);

        $this->assertNotFalse(
            strpos($result, 'DTSTART:' . $expectedStart)
        );
        $this->assertNotFalse(
            strpos($result, 'DTEND:' . $expectedEnd)
        );
    }

    public function dataProviderTestServiceCreatesFleamarketDateCalendarEvent()
    {
        $dates = [
            new FleaMarketDate('2016-10-23 11:00:00', '2016-10-23 23:00:00'),
            new FleaMarketDate('2016-10-25 15:00:00', '2016-10-25 23:50:00'),
            new FleaMarketDate('2016-10-29 10:00:00', '2016-10-29 16:00:00')
        ];

        return array(
            array($dates, new \DateTime('2016-10-23'), '20161023T110000', '20161023T230000'),
            array($dates, new \DateTime('2016-10-25'), '20161025T150000', '20161025T235000'),
            array($dates, new \DateTime('2016-10-29'), '20161029T100000', '20161029T160000')
        );
    }
}

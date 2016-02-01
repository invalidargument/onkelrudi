<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\PyStringNode;
use Behat\MinkExtension\Context\MinkContext;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDate;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketService;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;
use RudiBieller\OnkelRudi\FleaMarket\OrganizerService;
use RudiBieller\OnkelRudi\FleaMarket\Query\Factory;
use RudiBieller\OnkelRudi\FleaMarket\Query\OrganizerQueryFactory;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{
    private $_browser;
    private $_service;
    private $_organizerService;
    /**
     * @var \Buzz\Message\Response
     */
    private $_response;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $curl = new \Buzz\Client\Curl();
        $curl->setOption(CURLOPT_FOLLOWLOCATION, false);
        $this->_browser = new \Buzz\Browser($curl);

        $factory = new Factory();
        $this->_service = new FleaMarketService();
        $this->_service->setQueryFactory($factory);

        $organizerQueryFactory = new OrganizerQueryFactory();
        $this->_organizerService = new OrganizerService();
        $this->_organizerService->setQueryFactory($organizerQueryFactory);
    }

    /** @BeforeScenario */
    public function before(BeforeScenarioScope $scope)
    {
        $this->_cleanupDatabase();
        $this->_response = null;
    }

    /** @AfterScenario */
    public function after(AfterScenarioScope $scope)
    {
        $this->_cleanupDatabase();
        $this->_response = null;
    }

    /**
     * @Given I have some fleamarkets
     */
    public function iHaveSomeFleamarkets()
    {
        try {
            $this->_createFleaMarkets();
        } catch(\Exception $e) {
            throw new \Exception("Could not create test fleamarket:\n" . $e->getMessage());
        }
    }

    /**
     * @Given I have some organizers
     */
    public function iHaveSomeOrganizers()
    {
        $this->_createOrganizers();
    }

    /**
     * @Given I have a default organizer
     */
    public function iHaveADefaultOrganizer()
    {
        $this->_createDefaultOrganizer();
    }

    /**
     * @Given I send a :arg1 request to :arg2
     */
    public function iSendARequestTo($arg1, $arg2)
    {
        $allowed = array('GET', 'POST', 'DELETE', 'PUT');
        if (!in_array($arg1, $allowed)) {
            throw new \InvalidArgumentException('Unsupported request method '.$arg1.'. Must be one of '.implode($allowed));
        }

        $method = strtolower($arg1);

        $this->_response = $this->_browser->$method($arg2);
    }

    /**
     * @Given I send a :arg1 request to :arg2 with body
     */
    public function iSendARequestToWithBody($arg1, $arg2, PyStringNode $string)
    {
        $allowed = array('POST', 'DELETE', 'PUT');
        if (!in_array($arg1, $allowed)) {
            throw new \InvalidArgumentException('Unsupported request method '.$arg1.' when sending content in body. Must be one of '.implode($allowed));
        }

        $method = strtolower($arg1);

        $this->_response = $this->_browser->$method($arg2, array('Content-Type: application/json'), (string)$string);
    }

    /**
     * @Then the response code should be :arg1
     */
    public function theResponseCodeShouldBe($arg1)
    {
        \PHPUnit_Framework_Assert::assertEquals($arg1, $this->_response->getStatusCode());
    }

    /**
     * @Then the response should be json
     */
    public function theResponseShouldBeJson()
    {
        \PHPUnit_Framework_Assert::assertJson($this->_response->getContent());
    }

    /**
     * @Then the response should be
     */
    public function theResponseShouldBe(PyStringNode $string)
    {
        \PHPUnit_Framework_Assert::assertEquals((string)$string, (string)$this->_response->getContent());
    }

    private function _createFleaMarkets($num = 3)
    {
        for($i=0; $i<$num; $i++) {
            $organizer = new Organizer();
            $organizer
                ->setUuid('uuid-'.$i)
                ->setName('Rudi #'.$i)
                ->setPhone('23')
                ->setCity('Köln')
                ->setZipCode('50000')
                ->setStreet('foo')
                ->setStreetNo('2000')
                ->setUrl('http://www.example.com');
            $id = $this->_organizerService->createOrganizer($organizer);
            $organizer->setId($id);
            $fleaMarket = new FleaMarket();
            $dates = [
                new FleaMarketDate('2016-12-12 08:01:02', '2016-12-13 20:20:20')
            ];
            $fleaMarket
                ->setUuid('uuid-'.$i)
                ->setName('Der  #'.$i.' Flohmarkt von Rudi')
                ->setOrganizer($organizer)
                ->setDescription('Ein toller Flohmarkt')
                ->setCity('Cologne')
                ->setZipCode('5000')
                ->setStreet('Venloer')
                ->setStreetNo('20000')
                ->setDates($dates)
                ->setLocation('Daheim')
                ->setUrl('http://www.example.com/foo');

            $this->_service->createFleaMarket($fleaMarket, $organizer);
        }
    }

    private function _createOrganizers($num = 3)
    {
        for ($i=0; $i<$num; $i++) {
            $organizer = new Organizer();
            $organizer
                ->setUuid('uuid-'.$i)
                ->setName('Max Power #'.$i)
                ->setPhone('23')
                ->setCity('Köln')
                ->setZipCode('50000')
                ->setStreet('foo')
                ->setStreetNo('2000')
                ->setUrl('http://www.example.com');
            $this->_organizerService->createOrganizer($organizer);
        }
    }

    private function _createDefaultOrganizer()
    {
        $organizer = new Organizer();
        $organizer
            ->setUuid('uuid-0')
            ->setName('Max Power')
            ->setPhone('23')
            ->setCity('Köln')
            ->setZipCode('50000')
            ->setStreet('foo')
            ->setStreetNo('2000')
            ->setUrl('http://www.example.com');
        $id = $this->_organizerService->createOrganizer($organizer);
    }

    private function _cleanupDatabase()
    {
        $this->_service->truncateTablesForTestCases();
    }
}

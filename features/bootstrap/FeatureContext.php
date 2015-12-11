<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\WebApiExtension\Context\WebApiContext;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketService;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;
use RudiBieller\OnkelRudi\FleaMarket\Query\Factory;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    private $_browser;
    private $_service;
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
        //$this->_cleanupDatabase();
        //$this->_response = null;
    }

    /**
     * @Given I have some fleamarkets in my database
     */
    public function iHaveSomeFleamarketsInMyDatabase()
    {
        try {
            $this->_createFleaMarkets();
        } catch(\Exception $e) {
            throw new \Exception("Could not create test fleamarket:\n" . $e->getMessage());
        }
    }

    /**
     * @Given I send a :arg1 request to :arg2
     */
    public function iSendARequestTo($arg1, $arg2)
    {
        $this->_response = $this->_browser->get($arg2);
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
     * @Then the response should contain all created fleamarkets
     */
    public function theResponseShouldContainAllCreatedFleamarkets()
    {
        $markets = json_decode($this->_response->getContent())->data;
        foreach ($markets as $key => $market) {
            \PHPUnit_Framework_Assert::assertEquals('Der  #'.$key.' Flohmarkt von Rudi', $market->name);
        }
    }

    /**
     * @Then the response should contain fleamarket with id :arg1
     */
    public function theResponseShouldContainFleamarketWithId($arg1)
    {
        var_dump($this->_response->getContent());
        \PHPUnit_Framework_Assert::assertEquals($arg1, $this->_response->getContent()->data);
    }

    private function _createFleaMarkets($num = 3)
    {
        for($i=0; $i<$num; $i++) {
            $organizer = new Organizer();
            $organizer->setName('Rudi #'.$i)
                ->setPhone('23')
                ->setCity('Köln')
                ->setZipCode('50000')
                ->setStreet('foo')
                ->setStreetNo('2000')
                ->setUrl('http://www.example.com');
            $id = $this->_service->createOrganizer($organizer);
            $organizer->setId($id);
            $fleaMarket = new FleaMarket();
            $fleaMarket->setName('Der  #'.$i.' Flohmarkt von Rudi')
                ->setOrganizer($organizer)
                ->setDescription('Ein toller Flohmarkt')
                ->setCity('Cologne')
                ->setZipCode('5000')
                ->setStreet('Venloer')
                ->setStreetNo('20000')
                ->setStart('2015-12-12 00:00:12')
                ->setEnd('2015-12-12 00:00:33')
                ->setLocation('Daheim')
                ->setUrl('http://www.example.com/foo');

            $id = $this->_service->createFleaMarket($fleaMarket, $organizer);
            var_dump('created fleamarket ', $id);
        }
    }

    private function _cleanupDatabase()
    {
        $this->_service->truncateTablesForTestCases();
    }
}

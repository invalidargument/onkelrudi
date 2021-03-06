<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\MinkExtension\Context\MinkContext;
use Buzz\Listener\CookieListener;
use RudiBieller\OnkelRudi\Config\Config;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketDate;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketService;
use RudiBieller\OnkelRudi\FleaMarket\Organizer;
use RudiBieller\OnkelRudi\FleaMarket\OrganizerService;
use RudiBieller\OnkelRudi\FleaMarket\Query\Factory;
use RudiBieller\OnkelRudi\FleaMarket\Query\OrganizerQueryFactory;
use RudiBieller\OnkelRudi\User\AuthenticationFactory;
use RudiBieller\OnkelRudi\User\NotificationService;
use RudiBieller\OnkelRudi\User\QueryFactory;
use RudiBieller\OnkelRudi\User\User;
use RudiBieller\OnkelRudi\User\UserService;
use RudiBieller\OnkelRudi\User\UserServiceInterface;
use Slim\PDO\Database;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{
    private $_browser;
    private $_service;
    private $_organizerService;
    /**
     * @var UserServiceInterface
     */
    private $_userService;
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
        $config = new Config();
        $appConfiguration = [
            // Onkel Rudi Configuration
            'config' => $config,
            // Database PDO instance
            'db' => function() use ($config) {
                $dbSettings = $config->getDatabaseConfiguration();

                return new Database(
                    $dbSettings['dsn'],
                    $dbSettings['user'],
                    $dbSettings['password']
                );
            }
        ];

        $container = new \Slim\Container($appConfiguration);

        $curl = new \Buzz\Client\Curl();
        $curl->setOption(CURLOPT_FOLLOWLOCATION, false);
        $this->_browser = new \Buzz\Browser($curl);
        $this->_browser->addListener(new CookieListener());

        $notificationService = new NotificationService();

        $factory = new Factory();
        $factory->setDiContainer($container);
        $this->_service = new FleaMarketService();
        $this->_service->setQueryFactory($factory);
        $this->_service->setNotificationService($notificationService);

        $organizerQueryFactory = new OrganizerQueryFactory();
        $organizerQueryFactory->setDiContainer($container);
        $this->_organizerService = new OrganizerService();
        $this->_organizerService->setQueryFactory($organizerQueryFactory);

        $userQueryFactory = new QueryFactory();
        $userQueryFactory->setDiContainer($container);
        $authenticationFactory = new AuthenticationFactory();
        $authenticationFactory->setDiContainer($container);
        $this->_userService = new UserService();
        $this->_userService->setQueryFactory($userQueryFactory);
        $this->_userService->setAuthenticationFactory($authenticationFactory);
        $this->_userService->setOrganizerService($this->_organizerService);
        $this->_userService->setDiContainer($container);
    }

    /** @BeforeScenario */
    public function before(BeforeScenarioScope $scope)
    {
        $this->_cleanupDatabase();
        $this->_response = null;

        if ($this->getSession()->getDriver() instanceof Behat\Mink\Driver\Selenium2Driver) {
            $this->setMinkParameter('base_url', 'http://localhost:8089/public/');
        }
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
     * @Given I have some fleamarkets within the upcoming timespan
     */
    public function iHaveSomeFleamarketsWithinTheUpcomingTimespan()
    {
        $this->_createFleaMarkets(3, false, true);
    }

    /**
     * @Given I have an expired fleamarket
     */
    public function iHaveAnExpiredFleamarket()
    {
        try {
            $this->_createFleaMarkets(1, true);
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

    /**
     * @When I wait for :arg1 seconds
     */
    public function iWaitForSeconds($arg1)
    {
        sleep($arg1);
    }

    /**
     * @Given I have a user with email :arg1 and optin token :arg2
     */
    public function iHaveAUserWithEmailAndOptinToken($arg1, $arg2)
    {
        $user = $this->_userService->createUser($arg1, 'password');
        $this->_userService->createTestOptInToken($arg1, $arg2);
    }

    /**
     * @When I optin my user :arg1
     */
    public function iOptinMyUser($arg1)
    {
        $this->_userService->optInTestUser($arg1);
    }

    /**
     * @Given I have an Organizer User with Email :arg1
     */
    public function iHaveAnOrganizerUserWithEmail($arg1, $optInToken = 'foo')
    {
        $user = $this->_userService->createOrganizerUser($arg1, password_hash('aaaaaaaa', PASSWORD_DEFAULT));
        $this->_userService->createTestOptInToken($arg1, $optInToken);
        $this->iOptinMyUser($arg1);
    }

    /**
     * @Given /^I am authenticated as user$/
     */
    public function iAmAuthenticatedAsUser()
    {
        $this->getSession()->getDriver()->setCookie('onkelrudi', '33ehcpch1a9f8ikcg20p8bhem5');
    }

    /**
     * @Given /^I am slowly authenticated as user$/
     * @Given I am slowly authenticated as user :arg1
     */
    public function iAmSlowlyAuthenticatedAsUser($arg1 = 'test@onkel-rudi.de')
    {
        $this->visit('/login/');
        $this->fillField('login_email', $arg1);
        $this->fillField('login_password', 'aaaaaaaa');
        $this->pressButton('Anmelden');
        $this->iWaitForSeconds(1);
    }

    /**
     * @Given /^I am authenticated as user via api$/
     */
    public function iAmAuthenticatedAsUserViaApi()
    {
        $this->iSendARequestToWithBody(
            'POST',
            'http://localhost/public/api/v1/login',
            new PyStringNode(['{"email":"test@onkel-rudi.de", "password": "aaaaaaaa"}'], 0));
    }

    /**
     * @Then the :arg1 attribute of the :arg2 element should contain :arg3
     */
    public function theAttributeOfTheElementShouldContain($arg1, $arg2, $arg3)
    {
        $this->assertSession()->elementAttributeContains('css', $arg2, $arg1, $arg3);
    }

    private function _createFleaMarkets($num = 3, $expired = false, $inUpcomingTimespan = false)
    {
        if ($expired === false) {
            if ($inUpcomingTimespan) {
                $dates = [
                    new FleaMarketDate(
                        new \DateTimeImmutable(date ('Y-m-d 08:01:02', strtotime('+1 week'))),
                        new \DateTimeImmutable(date ('Y-m-d 20:20:20', strtotime('+1 week')))
                    )
                ];
            } else {
                $dates = [
                    new FleaMarketDate(new \DateTimeImmutable('2016-12-12 08:01:02'), new \DateTimeImmutable('2016-12-13 20:20:20'))
                ];
            }
        } else {
            $dates = [
                new FleaMarketDate(new \DateTimeImmutable('2015-12-12 08:01:02'), new \DateTimeImmutable('2015-12-13 20:20:20'))
            ];
        }

        $user = new User('info@onkel-rudi.de');

        for($i=0; $i<$num; $i++) {
            $organizer = new Organizer();
            $organizer
                ->setUuid('uuid-'.$i)
                ->setName('Rudi #'.$i)
                ->setPhone('23')
                ->setEmail('foo@example.com')
                ->setCity('Köln')
                ->setZipCode('50000')
                ->setStreet('foo')
                ->setStreetNo('2000')
                ->setUrl('http://www.example.com');
            $id = $this->_organizerService->createOrganizer($organizer);
            $organizer->setId($id);
            $fleaMarket = new FleaMarket();
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
                ->setUrl('http://www.example.com/foo')
                ->setUser($user);

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
                ->setEmail('foo@example.com')
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
            ->setEmail('defaultorganizer@example.com')
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

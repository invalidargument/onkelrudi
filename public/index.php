<?php
include_once '../vendor/autoload.php';

use RudiBieller\OnkelRudi\BuilderFactory;
use RudiBieller\OnkelRudi\FleaMarket\Query\Factory;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketService;
use RudiBieller\OnkelRudi\FleaMarket\Organizer,
    RudiBieller\OnkelRudi\FleaMarket\FleaMarket;

use RudiBieller\OnkelRudi\Controller\Factory as ControllerFactory;

$app = new \Slim\App;
$factory = new Factory();
$service = new FleaMarketService();
$service->setQueryFactory($factory);
$controllerFactory = new ControllerFactory($app);
$controllerFactory->setService($service);

//try {
//    $organizer = new Organizer();
//    $organizer->setName('Rudi')
//        ->setPhone('23')
//        ->setCity('Köln')
//        ->setZipCode('50000')
//        ->setStreet('foo')
//        ->setStreetNo('2000')
//        ->setUrl('http://www.example.com');
//    $id = $service->createOrganizer($organizer);
//    $organizer->setId($id);
//    var_dump('organizer id', $id);
//
//    $fleaMarket = new FleaMarket();
//    $fleaMarket
//        ->setName('Der erste Flohmarkt von Rudi')
//        ->setOrganizer($organizer)
//        ->setDescription('Ein toller Flohmarkt')
//        ->setCity('Cologne')
//        ->setZipCode('5000')
//        ->setStreet('Venloer')
//        ->setStreetNo('20000')
//        ->setStart('2015-12-12 00:00:12')
//        ->setEnd('2015-12-12 00:00:33')
//        ->setLocation('Daheim')
//        ->setUrl('http://www.example.com/foo');
//
//    $id = $service->createFleaMarket($fleaMarket, $organizer);
//    var_dump('created fleamarket id', $id, $fleaMarket->getId());
//
//    $organizer->setCity('London');
//    $fleaMarket->setDescription('Mind the gap');
//    $fleaMarket->setName('External Market');
//    $result = $service->updateFleaMarket($fleaMarket, $organizer);
//    var_dump('fleamarket updated?', $result);
//
//    $readMarket = $service->getFleaMarket($fleaMarket->getId());
//    var_dump('read fleamarket', $readMarket);
//
//    $allMarkets = $service->getAllFleaMarkets();
////    var_dump('all fmarkets', $allMarkets);
//
//    //$deleted = $service->deleteFleaMarket($fleaMarket);
//    //var_dump('deleted fleamarket?', $deleted);
//
//    //$deleted = $service->deleteOrganizer($organizer);
//    //var_dump('deleted organizer?', $deleted);
//
//    $organizer->setId(3)->setName('Horst Ullrich')->setStreetNo(1);
//    $updatedOrganizer = $service->updateOrganizer($organizer);
//    var_dump('organizer updated?', $updatedOrganizer); // 0 - no affected rows, 1 - 1 affected row
//} catch (Exception $e) {
//    var_dump($e->getMessage());
//}

//die("END TEST");





//$app->get('/', function ($args) use ($app, $controllerFactory) {
//    $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\FleaMarketsAction');
//    $action($app->getContainer()->get('request'), $app->getContainer()->get('response'), array());
//});

$app->group('/api', function () use ($app, $controllerFactory) {

    $app->group('/v1', function () use ($app, $controllerFactory) {

        // GET list a specific fleamarket
        $app->get('/fleamarkets/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\FleaMarketAction');
            $action($app->getContainer()->get('request'), $app->getContainer()->get('response'), $args);
        });

        // GET list all fleamarkets
        $app->get('/fleamarkets', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\FleaMarketsAction');
            $action($app->getContainer()->get('request'), $app->getContainer()->get('response'), $args);
        });

        // PUT route, for updating a fleamarket
        $app->put('/fleamarkets/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\FleaMarketUpdateAction');
            $action($app->getContainer()->get('request'), $app->getContainer()->get('response'), $args);
        });

        // DELETE route, for deleting a fleamarket
        $app->delete('/fleamarkets/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\FleaMarketDeleteAction');
            $action($app->getContainer()->get('request'), $app->getContainer()->get('response'), $args);
        });

        // POST route, for creating a fleamarket
        $app->post('/fleamarkets/{data}', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\FleaMarketCreateAction');
            $action->setBuilderFactory(new BuilderFactory());
            $action($app->getContainer()->get('request'), $app->getContainer()->get('response'), $args);
        });
    });

});

$app->run();
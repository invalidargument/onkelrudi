<?php
include_once 'vendor/autoload.php';

use RudiBieller\OnkelRudi\FleaMarket\Query\Factory;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketService;
use RudiBieller\OnkelRudi\FleaMarket\Organizer,
    RudiBieller\OnkelRudi\FleaMarket\FleaMarket,
    RudiBieller\OnkelRudi\FleaMarket\FleaMarketDetails;

$app = new \Slim\App;
$factory = new Factory();
$service = new FleaMarketService();
$service->setQueryFactory($factory);

try {
    $organizer = new Organizer();
    $organizer->setName('Rudi')
        ->setPhone('23')
        ->setCity('Köln')
        ->setZipCode('50000')
        ->setStreet('foo')
        ->setStreetNo('2000')
        ->setUrl('http://www.example.com');
    $id = $service->createOrganizer($organizer);
    $organizer->setId($id);
    var_dump('organizer id', $id);

    $fleaMarket = new FleaMarket();
    $details = new FleaMarketDetails();

    $fleaMarket->setName('Der erste Flohmarkt von Rudi')
        ->setOrganizerId($id);

    $details->setDescription('Ein toller Flohmarkt')
        ->setCity('Cologne')
        ->setZipCode('5000')
        ->setStreet('Venloer')
        ->setStreetNo('20000')
        ->setStart('2015-12-12 00:00:12')
        ->setEnd('2015-12-12 00:00:33')
        ->setLocation('Daheim')
        ->setUrl('http://www.example.com/foo');

    $id = $service->createFleaMarket($fleaMarket, $details, $organizer);
    var_dump('fleamarket id', $id, $fleaMarket->getId(), $details->getId());

    $readMarket = $service->getFleaMarket($fleaMarket->getId());
    var_dump('read fleamarket', $readMarket);

    $allMarkets = $service->getAllFleaMarkets();
//    var_dump('all fmarkets', $allMarkets);

    $deleted = $service->deleteFleaMarket($fleaMarket);
    var_dump('deleted fleamarket?', $deleted);

    $deleted = $service->deleteOrganizer($organizer);
    var_dump('deleted organizer?', $deleted);
} catch (Exception $e) {
    var_dump($e->getMessage());
}

die("END TEST");








$app->get('/', function ($request, $response, $args) use ($app) {
//    return $response->write("<h1>It works!</h1>" . $args['name']);
    return $response->withHeader(
        'Content-Type',
        'application/json'
    )->write(json_encode(array('foo' => 'bar')));
});

$app->group('/api', function ($request, $response, $args) use ($app, $service) {

    $app->group('/v1', function ($request, $response, $args) use ($app, $service) {

        // GET list a specific fleamarket
        $app->get('/fleamarkets/{id}', function ($request, $response, $args) use ($app, $service) {
            return $app->response->withHeader(
                'Content-Type',
                'application/json'
            )->write(json_encode(array('fleamarkets' => 'show id ' . $args['id'])));
        });

        // GET list all fleamarkets
        $app->get('/fleamarkets', function ($request, $response, $args) use ($app, $service) {
            return $response->withHeader(
                'Content-Type',
                'application/json'
            )->write(json_encode(array('fleamarkets' => 'show all')));
        });

        // PUT route, for updating a fleamarket
        $app->put('/fleamarkets/{id}', function ($request, $response, $args) use ($app, $service) {
            return $response->withHeader(
                'Content-Type',
                'application/json'
            )->write(json_encode(array('fleamarkets' => 'update id' . $args['id'])));
        });

        // DELETE route, for deleting a fleamarket
        $app->delete('/fleamarkets/{id}', function ($request, $response, $args) use ($app, $service) {
            return $response->withHeader(
                'Content-Type',
                'application/json'
            )->write(json_encode(array('fleamarkets' => 'delete id ' . $args['id'])));
        });

        // POST route, for creating a fleamarket
        $app->post('/fleamarkets', function ($request, $response, $args) use ($app, $service) {
            return $app->response->withHeader(
                'Content-Type',
                'application/json'
            )->write(json_encode(array('fleamarkets' => 'create new')));
        });

    });

});

$app->run();
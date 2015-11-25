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
    $created = $service->createOrganizer($organizer);
    var_dump($created);
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
            $organizer = new Organizer();
            $created = $service->createOrganizer($organizer);

            $details = new FleaMarketDetails();

            $fleaMarket = new FleaMarket();
            $created = $service->createFleaMarket($fleaMarket, $details, $organizer);

            return $app->response->withHeader(
                'Content-Type',
                'application/json'
            )->write(json_encode(array('fleamarkets' => 'create new')));
        });

    });

});

$app->run();
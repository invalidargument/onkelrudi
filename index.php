<?php
include_once 'vendor/autoload.php';

$app = new \Slim\App;

$app->get('/', function ($request, $response, $args) use ($app) {
//    return $response->write("<h1>It works!</h1>" . $args['name']);
    return $response->withHeader(
        'Content-Type',
        'application/json'
    )->write(json_encode(array('foo' => 'bar')));
});

$app->group('/api', function ($request, $response, $args) use ($app) {

    $app->group('/v1', function ($request, $response, $args) use ($app) {

        // GET list a specific fleamarket
        $app->get('/fleamarkets/{id}', function ($request, $response, $args) use ($app) {
            return $app->response->withHeader(
                'Content-Type',
                'application/json'
            )->write(json_encode(array('fleamarkets' => 'show id ' . $args['id'])));
        });

        // GET list all fleamarkets
        $app->get('/fleamarkets', function ($request, $response, $args) use ($app) {
            return $response->withHeader(
                'Content-Type',
                'application/json'
            )->write(json_encode(array('fleamarkets' => 'show all')));
        });

        // PUT route, for updating a fleamarket
        $app->put('/fleamarkets/{id}', function ($request, $response, $args) use ($app) {
            return $response->withHeader(
                'Content-Type',
                'application/json'
            )->write(json_encode(array('fleamarkets' => 'update id' . $args['id'])));
        });

        // DELETE route, for deleting a fleamarket
        $app->delete('/fleamarkets/{id}', function ($request, $response, $args) use ($app) {
            return $response->withHeader(
                'Content-Type',
                'application/json'
            )->write(json_encode(array('fleamarkets' => 'delete id ' . $args['id'])));
        });

        // DELETE route, for deleting a fleamarket
        $app->post('/fleamarkets', function () use ($app) {
            return $app->response->withHeader(
                'Content-Type',
                'application/json'
            )->write(json_encode(array('fleamarkets' => 'create new')));
        });

    });

});

$app->run();
<?php
include_once '../vendor/autoload.php';

use RudiBieller\OnkelRudi\BuilderFactory;
use RudiBieller\OnkelRudi\FleaMarket\Query\Factory;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketService;
use RudiBieller\OnkelRudi\Controller\Factory as ControllerFactory;
use RudiBieller\OnkelRudi\Wordpress\QueryFactory;
use RudiBieller\OnkelRudi\Wordpress\Service as WpService;

$app = new \Slim\App;

// fleaMarkets
$service = new FleaMarketService();
$service->setQueryFactory(new Factory());

// wordpress
$wpService = new WpService();
$wpService->setQueryFactory(new QueryFactory());

// controller
$controllerFactory = new ControllerFactory($app);
$controllerFactory->setService($service);

$container = $app->getContainer();
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig(
        'templates',
        [
            //'cache' => 'templates/cache'
            'cache' => false,
            'debug' => true
        ]
    );

    $view->addExtension(new Slim\Views\TwigExtension(
        $c['router'],
        $c['request']->getUri()
    ));

    return $view;
};

$app->get('/', function ($request, $response, $args) use ($service, $wpService) {
    $fleaMarkets = $service->getAllFleaMarkets();
    $wpCategories = $wpService->getAllCategories();
    return $this->get('view')
        ->render($response, 'index.html', [
            'fleamarkets' => $fleaMarkets,
            'wpCategories' => $wpCategories
        ]);
})->setName('index');

$app->get('/admin/', function ($request, $response, $args) use ($service) {
    return $this->get('view')
        ->render($response, 'admin.html', []);
})->setName('admin');

$app->group('/api', function () use ($app, $controllerFactory) {

    $app->group('/v1', function () use ($app, $controllerFactory) {

        // ############# FleaMarket #############

        // GET list a specific fleamarket
        $app->get('/fleamarkets/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\FleaMarketAction');
            $action($request, $response, $args);
        });

        // GET list all fleamarkets
        $app->get('/fleamarkets', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\FleaMarketsAction');
            $action($request, $response, $args);
        });

        // PUT route, for updating a fleamarket
        $app->put('/fleamarkets/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\FleaMarketUpdateAction');
            $action->setBuilderFactory(new BuilderFactory());
            $action($request, $response, $args);
        });

        // DELETE route, for deleting a fleamarket
        $app->delete('/fleamarkets/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\FleaMarketDeleteAction');
            $action->setBuilderFactory(new BuilderFactory());
            $action($request, $response, $args);
        });

        // POST route, for creating a fleamarket
        $app->post('/fleamarkets', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\FleaMarketCreateAction');
            $action->setBuilderFactory(new BuilderFactory());
            $action($request, $response, $args);
        });

        // ############# Organizer #############

        // GET list a specific fleamarket
        $app->get('/organizers/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\OrganizerAction');
            $action($request, $response, $args);
        });

        // GET list all fleamarkets
        $app->get('/organizers', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\OrganizersAction');
            $action($request, $response, $args);
        });

        // PUT route, for updating a fleamarket
        $app->put('/organizers/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\OrganizerUpdateAction');
            $action->setBuilderFactory(new BuilderFactory());
            $action($request, $response, $args);
        });

        // DELETE route, for deleting a fleamarket
        $app->delete('/organizers/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\OrganizerDeleteAction');
            $action->setBuilderFactory(new BuilderFactory());
            $action($request, $response, $args);
        });

        // POST route, for creating a fleamarket
        $app->post('/organizers', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\OrganizerCreateAction');
            $action->setBuilderFactory(new BuilderFactory());
            $action($request, $response, $args);
        });
    });

});

$app->run();
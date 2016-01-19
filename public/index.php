<?php
include_once '../vendor/autoload.php';

use RudiBieller\OnkelRudi\BuilderFactory;
use RudiBieller\OnkelRudi\FleaMarket\OrganizerService;
use RudiBieller\OnkelRudi\FleaMarket\Query\Factory;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketService;
use RudiBieller\OnkelRudi\Controller\Factory as ControllerFactory;
use RudiBieller\OnkelRudi\FleaMarket\Query\OrganizerQueryFactory;
use RudiBieller\OnkelRudi\Wordpress\QueryFactory;
use RudiBieller\OnkelRudi\Wordpress\Service as WpService;

$app = new \Slim\App;
$container = $app->getContainer();
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig(
        'templates',
        [
            //'cache' => 'templates/cache'
            'cache' => false
        ]
    );

    $view->addExtension(new Slim\Views\TwigExtension(
        $c['router'],
        $c['request']->getUri()
    ));

    return $view;
};

// fleaMarkets
$service = new FleaMarketService();
$service->setQueryFactory(new Factory());
// organizers
$organizerService = new OrganizerService();
$organizerService->setQueryFactory(new OrganizerQueryFactory());

// wordpress
$wpService = new WpService();
$wpService->setQueryFactory(new QueryFactory());

// controller
$controllerFactory = new ControllerFactory($app);
$controllerFactory->setService($service);
$controllerFactory->setOrganizerService($organizerService);

// Index
$app->get('/', function ($request, $response, $args) use ($service, $wpService, $app) {
    $fleaMarkets = $service->getAllFleaMarkets();
    $wpCategories = $wpService->getAllCategories();
    $fleaMarketsDetailRoutes = [];
    foreach($fleaMarkets as $fleaMarket) {
        $fleaMarketsDetailRoutes[$fleaMarket->getId()] = $app->getContainer()->router->pathFor('event-date', [
            'wildcard' => $fleaMarket->getSlug(),
            'id' => $fleaMarket->getId()
        ]);
    }
    // we need a middleware to convert links to url-compliant representation
    return $this->get('view')
        ->render($response, 'index.html', [
            'fleamarkets' => $fleaMarkets,
            'fleamarketsDetailsRoutes' => $fleaMarketsDetailRoutes,
            'wpCategories' => $wpCategories
        ]);
})->setName('index');

// FleaMarket Detail View
$app->get('/{wildcard}/termin/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
    $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\FleaMarketDetailAction');
    $action($request, $response, $args);
})->setName('event-date');

// Admin View
$app->get('/admin/', function ($request, $response, $args) use ($organizerService) {
    $fleamarketOrganizers = [];
    foreach ($organizerService->getAllOrganizers() as $organizer) {
        $fleamarketOrganizers[] = ['id' => $organizer->getId(), 'name' => $organizer->getName()];
    }

    return $this->get('view')
        ->render($response, 'admin.html', [
            'fleamarket_organizers' => $fleamarketOrganizers
        ]);
})->setName('admin');

// API routes
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
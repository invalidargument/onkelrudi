<?php
include_once '../vendor/autoload.php';

use RudiBieller\OnkelRudi\BuilderFactory;
use RudiBieller\OnkelRudi\Config\Config;
use RudiBieller\OnkelRudi\FleaMarket\OrganizerService;
use RudiBieller\OnkelRudi\FleaMarket\Query\Factory;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketService;
use RudiBieller\OnkelRudi\Controller\Factory as ControllerFactory;
use RudiBieller\OnkelRudi\FleaMarket\Query\OrganizerQueryFactory;
use RudiBieller\OnkelRudi\User\UserService;
use RudiBieller\OnkelRudi\User\QueryFactory as UserQueryFactory;
use RudiBieller\OnkelRudi\Wordpress\QueryFactory;
use RudiBieller\OnkelRudi\Wordpress\Service as WpService;

$envSettings = [
    'displayErrorDetails' => false,
    'cache' => 'templates/cache'
];

if ((new Config())->getSystemConfiguration()['environment'] === 'dev') {
    $envSettings['displayErrorDetails'] = true;
    $envSettings['cache'] = false;
}

$appConfiguration = [
    // general Slim settings
    'settings' => [
        'displayErrorDetails' => $envSettings['displayErrorDetails'],
    ],
    // Twig view
    'view' => function ($c) use ($envSettings) {
        $view = new \Slim\Views\Twig(
            'templates',
            ['cache' => $envSettings['cache']]
        );

        $view->addExtension(new Slim\Views\TwigExtension(
            $c['router'],
            $c['request']->getUri()
        ));

        return $view;
    }
];

$container = new \Slim\Container($appConfiguration);

$app = new \Slim\App($container);


// fleaMarkets
$service = new FleaMarketService();
$service->setQueryFactory(new Factory());
// organizers
$organizerService = new OrganizerService();
$organizerService->setQueryFactory(new OrganizerQueryFactory());
// users
$userService = new UserService();
$userService->setQueryFactory(new UserQueryFactory());

// wordpress
$wpService = new WpService();
$wpService->setQueryFactory(new QueryFactory());

// controller
$controllerFactory = new ControllerFactory($app);
$controllerFactory->setService($service);
$controllerFactory->setOrganizerService($organizerService);
$controllerFactory->setUserService($userService);
$controllerFactory->setWordpressService($wpService);

// Index
$app->get('/', function ($request, $response, $args) use ($service, $wpService, $app) {
    $fleaMarkets = $service->getAllUpcomingFleaMarkets();
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

// Blog Category View
$app->get('/{wildcard}/kategorie/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
    $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\WordpressCategoryAction');
    $action($request, $response, $args);
})->setName('wp-category');

// Registration/Login form
$app->get('/login/', function ($request, $response, $args) use ($app, $controllerFactory) {
    $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\LoginAction');
    $action($request, $response, $args);
})->setName('login-register');

// Admin View
$app->get('/admin/', function ($request, $response, $args) use ($organizerService, $wpService) {
    $fleamarketOrganizers = [];
    foreach ($organizerService->getAllOrganizers() as $organizer) {
        $fleamarketOrganizers[] = ['id' => $organizer->getId(), 'name' => $organizer->getName()];
    }

    $isTest = strpos($request->getUri()->getQuery(), 'test=1') !== false;

    $wpCategories = $wpService->getAllCategories();

    return $this->get('view')
        ->render($response, 'admin.html', [
            'fleamarket_organizers' => $fleamarketOrganizers,
            'wpCategories' => $wpCategories,
            'isTest' => $isTest
        ]);
})->setName('admin');

// API routes
$app->group('/api', function () use ($app, $controllerFactory) {

    $app->group('/v1', function () use ($app, $controllerFactory) {

        // ############# FleaMarket #############

        // GET list a specific fleamarket
        $app->get('/fleamarkets/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\FleaMarketAction');
            return $action($request, $response, $args);
        });

        // GET list all fleamarkets
        $app->get('/fleamarkets', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\FleaMarketsAction');
            return $action($request, $response, $args);
        });

        // PUT route, for updating a fleamarket
        $app->put('/fleamarkets/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\FleaMarketUpdateAction');
            $action->setBuilderFactory(new BuilderFactory());
            return $action($request, $response, $args);
        });

        // DELETE route, for deleting a fleamarket
        $app->delete('/fleamarkets/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\FleaMarketDeleteAction');
            $action->setBuilderFactory(new BuilderFactory());
            return $action($request, $response, $args);
        });

        // POST route, for creating a fleamarket
        $app->post('/fleamarkets', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\FleaMarketCreateAction');
            $action->setBuilderFactory(new BuilderFactory());
            return $action($request, $response, $args);
        });

        // ############# Organizer #############

        // GET list a specific Organizer
        $app->get('/organizers/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\OrganizerAction');
            return $action($request, $response, $args);
        });

        // GET list all Organizers
        $app->get('/organizers', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\OrganizersAction');
            return $action($request, $response, $args);
        });

        // PUT route, for updating an Organizer
        $app->put('/organizers/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\OrganizerUpdateAction');
            $action->setBuilderFactory(new BuilderFactory());
            return $action($request, $response, $args);
        });

        // DELETE route, for deleting an Organizer
        $app->delete('/organizers/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\OrganizerDeleteAction');
            $action->setBuilderFactory(new BuilderFactory());
            return $action($request, $response, $args);
        });

        // POST route, for creating an Organizer
        $app->post('/organizers', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\OrganizerCreateAction');
            $action->setBuilderFactory(new BuilderFactory());
            return $action($request, $response, $args);
        });

        // ############# User #############

        // POST route, for creating a user
        $app->post('/users', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\UserCreateAction');
            $action->setBuilderFactory(new BuilderFactory());
            return $action($request, $response, $args);
        });
    });

});

$app->run();
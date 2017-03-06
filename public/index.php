<?php
include_once '../vendor/autoload.php';

use RudiBieller\OnkelRudi\BuilderFactory;
use RudiBieller\OnkelRudi\Cache\CacheManagerFactory;
use RudiBieller\OnkelRudi\FleaMarket\OrganizerService;
use RudiBieller\OnkelRudi\FleaMarket\Query\Factory;
use RudiBieller\OnkelRudi\FleaMarket\FleaMarketService;
use RudiBieller\OnkelRudi\Controller\Factory as ControllerFactory;
use RudiBieller\OnkelRudi\FleaMarket\Query\OrganizerQueryFactory;
use RudiBieller\OnkelRudi\Ical\Service;
use RudiBieller\OnkelRudi\OnkelRudi;
use RudiBieller\OnkelRudi\User\AuthenticationFactory;
use RudiBieller\OnkelRudi\User\NotificationService;
use RudiBieller\OnkelRudi\User\UserBuilder;
use RudiBieller\OnkelRudi\User\UserService;
use RudiBieller\OnkelRudi\User\QueryFactory as UserQueryFactory;
use RudiBieller\OnkelRudi\Wordpress\QueryFactory;
use RudiBieller\OnkelRudi\Wordpress\Service as WpService;
use Slim\PDO\Database;

$onkelRudi = new OnkelRudi();

$config = $onkelRudi->getConfig();
$db = null;

$envSettings = $onkelRudi->getEnvironmentSettings();

// notifications
$notificationService = new NotificationService();
// fleaMarkets
$fleaMarketQueryFactory = new Factory();
$service = new FleaMarketService();
$service->setQueryFactory($fleaMarketQueryFactory);
$service->setNotificationService($notificationService);
// organizers
$organizerQueryFactory = new OrganizerQueryFactory();
$organizerService = new OrganizerService();
$organizerService->setQueryFactory($organizerQueryFactory);
// users
$userQueryFactory = new UserQueryFactory();
$authFactory = new AuthenticationFactory();
$userService = new UserService();
$userService->setQueryFactory($userQueryFactory);
$userService->setAuthenticationFactory($authFactory);
$userService->setOrganizerService($organizerService);

// wordpress
$wpQueryFactory = new QueryFactory();
$wpService = new WpService();
$wpService->setQueryFactory($wpQueryFactory);

// ical
$icalService = new Service();

$appConfiguration = [
    // General Slim settings
    'settings' => [
        'displayErrorDetails' => $envSettings['displayErrorDetails'],
        'logger' => [
            'name' => 'onkelrudi-logger',
            'level' => Monolog\Logger::DEBUG,
            'path' => $config->getSystemConfiguration()['log-path']
        ]
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
    },
    // Onkel Rudi Configuration
    'config' => $config,
    // Database PDO instance
    'db' => function() use ($config, $db) {
        if (is_null($db)) {
            $dbSettings = $config->getDatabaseConfiguration();

            $db = new Database(
                $dbSettings['dsn'],
                $dbSettings['user'],
                $dbSettings['password']
            );
        }

        return $db;
    },
    'Logger' => function($c) {
        $logger = new Monolog\Logger($c['settings']['logger']['name']);
        $filename = $c['settings']['logger']['path'];
        $stream = new Monolog\Handler\StreamHandler($filename, $c['settings']['logger']['level']);
        $fingersCrossed = new Monolog\Handler\FingersCrossedHandler($stream, Monolog\Logger::ERROR);
        $logger->pushHandler($fingersCrossed);

        return $logger;
    },
    'errorHandler' => function ($c) {
        return new RudiBieller\OnkelRudi\Handler\Error($c['Logger']);
    },
    'CacheManager' => function($c) use ($config) {
        return (new CacheManagerFactory())->createCacheManager($config);
    },
    'UserBuilder' => function ($c) {
        return new UserBuilder();
    },
    'OrganizerService' => function ($c) use ($organizerService) {
        return $organizerService;
    }
];

$container = new \Slim\Container($appConfiguration);

$app = new \Slim\App($container);

$fleaMarketQueryFactory->setDiContainer($app->getContainer());
$organizerQueryFactory->setDiContainer($app->getContainer());
$userQueryFactory->setDiContainer($app->getContainer());
$authFactory->setDiContainer($app->getContainer());
$userService->setDiContainer($app->getContainer());
$wpQueryFactory->setDiContainer($app->getContainer());

// controller
$controllerFactory = new ControllerFactory($app);
$controllerFactory->setService($service);
$controllerFactory->setOrganizerService($organizerService);
$controllerFactory->setUserService($userService);
$controllerFactory->setNotificationService($notificationService);
$controllerFactory->setWordpressService($wpService);
$controllerFactory->setIcalService($icalService);

// ########### ROUTING ####################

// Index
$app->get('/', function ($request, $response, $args) use ($app, $controllerFactory) {
    $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\IndexAction');
    $action($request, $response, $args);
})->setName('index');
$app->get('/monat/{month}/plz/{zip}', function ($request, $response, $args) use ($app, $controllerFactory) {
    $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\IndexAction');
    $action($request, $response, $args);
})->setName('index-paging');

// ICal create view
$app->get('/ical/termin/{id}/datum/{date}', function ($request, $response, $args) use ($app, $controllerFactory) {
    $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\IcalAction');
    return $action($request, $response, $args);
})->setName('ical-export');

// FleaMarket Detail View (with/without date)
$app->get('/{wildcard}/termin/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
    $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\FleaMarketDetailAction');
    $action($request, $response, $args);
})->setName('event-date');
$app->get('/{wildcard}/termin/{id}/datum/{date}', function ($request, $response, $args) use ($app, $controllerFactory) {
    $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\FleaMarketDetailAction');
    $action($request, $response, $args);
})->setName('event-date');

// Blog Category View
$app->get('/blog/kategorie/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
    $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\WordpressCategoryAction');
    $action($request, $response, $args);
})->setName('wp-category');
// Blog Post Detail View
$app->get('/blog/{wildcard}/post/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
    $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\WordpressPostAction');
    $action($request, $response, $args);
})->setName('wp-post');

// Registration/Login form
$app->get('/login/', function ($request, $response, $args) use ($app, $controllerFactory) {
    $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\LoginAction');
    $action($request, $response, $args);
})->setName('login-register');
$app->get('/logout/', function ($request, $response, $args) use ($app, $controllerFactory) {
    $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\LogoutAction');
    $action($request, $response, $args);
})->setName('logout');
// change password
$app->get('/passwort-aendern/', function ($request, $response, $args) use ($app, $controllerFactory) {
    $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\ChangePasswordAction');
    $action($request, $response, $args);
})->setName('password');

// opt-in confirmation
$app->get('/opt-in/token-{token}', function ($request, $response, $args) use ($app, $controllerFactory) {
    $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\OptInAction');
    return $action($request, $response, $args);
})->setName('optin-confirmation');

// USER: profile view
$app->get('/profil/', function ($request, $response, $args) use ($controllerFactory) {
    $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\ProfileAction');
    return $action($request, $response, $args);
})->setName('profile');
$app->get('/profil/seite/{page}', function ($request, $response, $args) use ($controllerFactory) {
    $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\ProfileAction');
    return $action($request, $response, $args);
})->setName('profile-paged');

// USER: create fleamarket view
$app->get('/flohmarkt-anlegen/', function ($request, $response, $args) use ($controllerFactory) {
    $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\CreateFleaMarketAction');
    return $action($request, $response, $args);
})->setName('create-fleamarket');
// USER: edit fleamarket view
$app->get('/flohmarkt-bearbeiten/{id}', function ($request, $response, $args) use ($controllerFactory) {
    $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\EditFleaMarketAction');
    return $action($request, $response, $args);
})->setName('edit-fleamarket');

// API routes
$app->group('/api', function () use ($app, $controllerFactory) {

    $app->group('/v1', function () use ($app, $controllerFactory) {

        // ############# FleaMarket #############

        // GET list a specific fleamarket
        $app->get('/fleamarkets/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\Api\FleaMarketAction');
            return $action($request, $response, $args);
        });

        // GET list all fleamarkets
        $app->get('/fleamarkets', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\Api\FleaMarketsAction');
            return $action($request, $response, $args);
        });

        // PUT route, for updating a fleamarket
        $app->put('/fleamarkets/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\Api\FleaMarketUpdateAction');
            $action->setBuilderFactory(new BuilderFactory());
            return $action($request, $response, $args);
        });

        // DELETE route, for deleting a fleamarket
        $app->delete('/fleamarkets/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\Api\FleaMarketDeleteAction');
            $action->setBuilderFactory(new BuilderFactory());
            return $action($request, $response, $args);
        });

        // POST route, for creating a fleamarket
        $app->post('/fleamarkets', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\Api\FleaMarketCreateAction');
            $action->setBuilderFactory(new BuilderFactory());
            return $action($request, $response, $args);
        });

        // ############# Organizer #############

        // GET list a specific Organizer
        $app->get('/organizers/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\Api\OrganizerAction');
            return $action($request, $response, $args);
        });

        // GET list all Organizers
        $app->get('/organizers', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\Api\OrganizersAction');
            return $action($request, $response, $args);
        });

        // PUT route, for updating an Organizer
        $app->put('/organizers/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\Api\OrganizerUpdateAction');
            $action->setBuilderFactory(new BuilderFactory());
            return $action($request, $response, $args);
        });

        // DELETE route, for deleting an Organizer
        $app->delete('/organizers/{id}', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\Api\OrganizerDeleteAction');
            $action->setBuilderFactory(new BuilderFactory());
            return $action($request, $response, $args);
        });

        // POST route, for creating an Organizer
        $app->post('/organizers', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\Api\OrganizerCreateAction');
            $action->setBuilderFactory(new BuilderFactory());
            return $action($request, $response, $args);
        });

        // ############# User #############

        // POST route, for creating a user
        $app->post('/users', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\Api\UserCreateAction');
            return $action($request, $response, $args);
        });
        // POST route, for changing password
        $app->post('/users/{id}/password/change', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\Api\UserPasswordChangeAction');
            return $action($request, $response, $args);
        });
        // POST route, for changing password
        $app->post('/users/{id}/password/reset', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\Api\UserPasswordResetAction');
            return $action($request, $response, $args);
        });

        // POST route, for logging in a user
        $app->post('/login', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\Api\UserLoginAction');
            $action->setBuilderFactory(new BuilderFactory());
            return $action($request, $response, $args);
        });

        // POST route, for logging out a user
        $app->post('/logout', function ($request, $response, $args) use ($app, $controllerFactory) {
            $action = $controllerFactory->createActionByName('RudiBieller\OnkelRudi\Controller\Api\UserLogoutAction');
            $action->setBuilderFactory(new BuilderFactory());
            return $action($request, $response, $args);
        });
    });

});

$app->run();
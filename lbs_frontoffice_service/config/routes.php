<?php

namespace config;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function (App $app) {
    $app->group('/v1', function (RouteCollectorProxy $app) {
        $app->post('/signin[/]', \frontoffice\actions\signin\PostSigninAction::class)->setName('postSignin');
        $app->get('/orders[/]', \frontoffice\actions\order\GetOrdersAction::class)->setName('getValidate')->add(\frontoffice\middlewares\ValidatorTokenMiddleware::class);
    });
};

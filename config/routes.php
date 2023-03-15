<?php

namespace config;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

use orders\middlewares\ValidatorPutOrderMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function (App $app) {
    $app->group('/v1', function (RouteCollectorProxy $app) {
        $app->get('/orders[/]', \orders\actions\order\GetOrdersAction::class)->setName('getOrders');
        $app->get('/orders/{id}[/]', \orders\actions\order\GetOrderByIdAction::class)->setName('getOrderById');
        $app->put('/orders/{id}[/]', \orders\actions\order\PutOrderByIdAction::class)->setName('putOrdersById')
            ->add(new ValidatorPutOrderMiddleware(Request::class));
    });
};

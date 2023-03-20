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
        $app->get('/orders/{id}/items', \orders\actions\order\GetOrderItemsByIdAction::class)->setName('getOrderItemsById');
        $app->post('/orders[/]', \orders\actions\order\PostOrderAction::class)->setName('postOrder')->add(new \orders\middlewares\ValidatorPostOrderMiddleware(Request::class));;
        $app->put('/orders/{id}[/]', \orders\actions\order\PutOrderByIdAction::class)->setName('putOrderById')
            ->add(new ValidatorPutOrderMiddleware(Request::class));
    });
};

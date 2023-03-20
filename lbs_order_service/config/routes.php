<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('', function (RouteCollectorProxy $app) {
        $app->get('/orders', \order\actions\order\GetOrdersAction::class)->setName('orders');
        $app->get('/orders/{id}', \order\actions\order\GetOrderByIdAction::class)->setName('order');
        $app->get('/orders/{id}/items', \order\actions\order\GetOrderItemsAction::class)->setName('items');

    }
    );
};
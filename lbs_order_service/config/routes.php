<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('', function (RouteCollectorProxy $app) {
        $app->get('/orders', \order\public\src\actions\order\GetOrdersAction::class)->setName('getOrders');
        $app->get('/orders/{id}', \sandwich\public\src\actions\order\GetOrderByIdAction::class)->setName('getOrdersById');
    }
    );
};
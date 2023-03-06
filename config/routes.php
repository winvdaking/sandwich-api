<?php
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('', function (RouteCollectorProxy $app) {
        $app->get('/orders', \lbs\order\Action\Order\GetOrdersAction::class)->setName('getOrders');
        $app->get('/orders/{id}', \lbs\order\Action\Order\GetOrderByIdAction::class)->setName('getOrdersById');
    }
    );
};
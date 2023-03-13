<?php

namespace orders\actions\order;

use orders\services\utils\OrderService;
use orders\errors\exceptions\OrderExceptionNotFound;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;


final class GetOrdersAction {

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            $orderService = new OrderService();
            $orders = $orderService->getOrders();
        } catch (OrderExceptionNotFound $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

        $data = [
            'type' => 'collection',
            'count' => count($orders),
            'orders' => $orders
        ];

        $response = $response->withHeader('Content-type', 'application/json;charset=utf-8')->withStatus(202);
        $response->getBody()->write(json_encode($data));

        return $response;
    }
}

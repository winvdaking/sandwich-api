<?php

namespace orders\actions\order;

use orders\services\utils\OrderService;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class GetOrderByIdAction{
    public function __invoke(Request $request,
                             Response $response , array $args): Response{
        $orderServive = new OrderService();
        $order = $orderServive->getOrdersById($args['id']);
        $data = [
            'type' => 'resource',
            'order' => $order
        ];
        $response = $response->withHeader('Content-type', 'application/json;charset=utf-8')->withStatus(202);
        $response->getBody()->write(json_encode($data));
        return $response;

    }
}
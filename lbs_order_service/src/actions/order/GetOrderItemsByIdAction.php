<?php

namespace orders\actions\order;


use orders\services\utils\OrderService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class GetOrderItemsByIdAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try{
            $orderService = new OrderService();
            $items = $orderService->getOrderItems($args['id']);
        } catch (OrderExceptionNotFound $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

        $data = [
            'type' => 'collection',
            'count' => count($items),
            'items' => $items,

        ];

        $response = $response->withHeader('Content-type', 'application/json;charset=utf-8')->withStatus(200);
        $response->getBody()->write(json_encode($data));

        return $response;
    }
}

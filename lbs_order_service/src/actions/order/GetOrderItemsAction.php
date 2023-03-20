<?php
namespace order\actions\order;


use order\services\utils\OrderService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class GetOrderItemsAction{
    public function __invoke(Request $request, Response $response , array $args): Response
    {
        $orderServive = new OrderService();
        $items = $orderServive->getOrderItems($args['id']);
        $data = [
            'type' => 'collection',
            'count' => count($items),
            'items' => $items,
           /* 'links' => [
                'self' =>[
                    'href' => $routeParser->urlFor('order', ['id'=>$order['id']])
                ]
            ]*/
        ];
        $response = $response->withHeader('Content-type', 'application/json;charset=utf-8')->withStatus(200);
        $response->getBody()->write(json_encode($data));
        return $response;
    }
}
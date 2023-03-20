<?php

namespace orders\actions\order;

use orders\services\utils\OrderService;
use orders\errors\exceptions\OrderExceptionNotFound;
use Slim\Routing\RouteContext;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;


final class GetOrdersAction {

    public function __invoke(Request $request, Response $response, array $args): Response
    {

        $client = $request->getQueryParams()['c']?? null;

        try {
            $uri = $request->getUri()->getPath();

            $orderService = new OrderService();
            $orders = $orderService->getOrders($client);
        } catch (OrderExceptionNotFound $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

        $orders_data = [];
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        foreach ($orders as $order){
            $orders_data[] = ['order' => [$order,
                'links' => ['self' => ['href' => $routeParser->urlFor('getOrderById', ['id'=>$order['id']])
                ]]]
            ];
        }

        $data = [
            'type' => 'collection',
            'count' => count($orders),
            'orders' =>
                $orders_data
        ];

        $response = $response->withHeader('Content-type', 'application/json;charset=utf-8')->withStatus(202);
        $response->getBody()->write(json_encode($data));

        return $response;
    }
}
